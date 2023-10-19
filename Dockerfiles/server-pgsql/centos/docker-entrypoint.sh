#!/bin/bash

set -o pipefail

set +e

# Script trace mode
if [ "${DEBUG_MODE,,}" == "true" ]; then
    set -o xtrace
fi

#Enable PostgreSQL timescaleDB feature:
: ${ENABLE_TIMESCALEDB:="false"}

# Default directories
# User 'zabbix' home directory
ZABBIX_USER_HOME_DIR="/var/lib/zabbix"
# Configuration files directory
ZABBIX_ETC_DIR="/etc/zabbix"

# usage: file_env VAR [DEFAULT]
# as example: file_env 'MYSQL_PASSWORD' 'zabbix'
#    (will allow for "$MYSQL_PASSWORD_FILE" to fill in the value of "$MYSQL_PASSWORD" from a file)
# unsets the VAR_FILE afterwards and just leaving VAR
file_env() {
    local var="$1"
    local fileVar="${var}_FILE"
    local defaultValue="${2:-}"

    if [ "${!var:-}" ] && [ "${!fileVar:-}" ]; then
        echo "**** Both variables $var and $fileVar are set (but are exclusive)"
        exit 1
    fi

    local val="$defaultValue"

    if [ "${!var:-}" ]; then
        val="${!var}"
        echo "** Using ${var} variable from ENV"
    elif [ "${!fileVar:-}" ]; then
        if [ ! -f "${!fileVar}" ]; then
            echo "**** Secret file \"${!fileVar}\" is not found"
            exit 1
        fi
        val="$(< "${!fileVar}")"
        echo "** Using ${var} variable from secret file"
    fi
    export "$var"="$val"
    unset "$fileVar"
}

escape_spec_char() {
    local var_value=$1

    var_value="${var_value//\\/\\\\}"
    var_value="${var_value//[$'\n']/}"
    var_value="${var_value//\//\\/}"
    var_value="${var_value//./\\.}"
    var_value="${var_value//\*/\\*}"
    var_value="${var_value//^/\\^}"
    var_value="${var_value//\$/\\\$}"
    var_value="${var_value//\&/\\\&}"
    var_value="${var_value//\[/\\[}"
    var_value="${var_value//\]/\\]}"

    echo "$var_value"
}

update_config_var() {
    local config_path=$1
    local var_name=$2
    local var_value=$3
    local is_multiple=$4

    local masklist=("DBPassword TLSPSKIdentity")

    if [ ! -f "$config_path" ]; then
        echo "**** Configuration file '$config_path' does not exist"
        return
    fi

    if [[ " ${masklist[@]} " =~ " $var_name " ]] && [ ! -z "$var_value" ]; then
        echo -n "** Updating '$config_path' parameter \"$var_name\": '****'. Enable DEBUG_MODE to view value ..."
    else
        echo -n "** Updating '$config_path' parameter \"$var_name\": '$var_value'..."
    fi

    # Remove configuration parameter definition in case of unset parameter value
    if [ -z "$var_value" ]; then
        sed -i -e "/^$var_name=/d" "$config_path"
        echo "removed"
        return
    fi

    # Remove value from configuration parameter in case of double quoted parameter value
    if [ "$var_value" == '""' ]; then
        sed -i -e "/^$var_name=/s/=.*/=/" "$config_path"
        echo "undefined"
        return
    fi

    # Use full path to a file for TLS related configuration parameters
    if [[ $var_name =~ ^TLS.*File$ ]] && [[ ! $var_value =~ ^/.+$ ]]; then
        var_value=$ZABBIX_USER_HOME_DIR/enc/$var_value
    fi

    # Escaping characters in parameter value and name
    var_value=$(escape_spec_char "$var_value")
    var_name=$(escape_spec_char "$var_name")

    if [ "$(grep -E "^$var_name=" $config_path)" ] && [ "$is_multiple" != "true" ]; then
        sed -i -e "/^$var_name=/s/=.*/=$var_value/" "$config_path"
        echo "updated"
    elif [ "$(grep -Ec "^# $var_name=" $config_path)" -gt 1 ]; then
        sed -i -e  "/^[#;] $var_name=$/i\\$var_name=$var_value" "$config_path"
        echo "added first occurrence"
    else
        sed -i -e "/^[#;] $var_name=/s/.*/&\n$var_name=$var_value/" "$config_path"
        echo "added"
    fi

}

update_config_multiple_var() {
    local config_path=$1
    local var_name=$2
    local var_value=$3

    var_value="${var_value%\"}"
    var_value="${var_value#\"}"

    local IFS=,
    local OPT_LIST=($var_value)

    for value in "${OPT_LIST[@]}"; do
        update_config_var $config_path $var_name $value true
    done
}

# Check prerequisites for PostgreSQL database
check_variables_postgresql() {
    file_env POSTGRES_USER
    file_env POSTGRES_PASSWORD

    : ${DB_SERVER_HOST:="postgres-server"}
    : ${DB_SERVER_PORT:="5432"}

    DB_SERVER_ROOT_USER=${POSTGRES_USER:-"postgres"}
    DB_SERVER_ROOT_PASS=${POSTGRES_PASSWORD:-""}

    DB_SERVER_ZBX_USER=${POSTGRES_USER:-"zabbix"}
    DB_SERVER_ZBX_PASS=${POSTGRES_PASSWORD:-"zabbix"}

    : ${DB_SERVER_SCHEMA:="public"}

    DB_SERVER_DBNAME=${POSTGRES_DB:-"zabbix"}

    : ${POSTGRES_USE_IMPLICIT_SEARCH_PATH:="false"}
}

check_db_connect_postgresql() {
    echo "********************"
    echo "* DB_SERVER_HOST: ${DB_SERVER_HOST}"
    echo "* DB_SERVER_PORT: ${DB_SERVER_PORT}"
    echo "* DB_SERVER_DBNAME: ${DB_SERVER_DBNAME}"
    echo "* DB_SERVER_SCHEMA: ${DB_SERVER_SCHEMA}"
    if [ "${DEBUG_MODE,,}" == "true" ]; then
        echo "* DB_SERVER_ZBX_USER: ${DB_SERVER_ZBX_USER}"
        echo "* DB_SERVER_ZBX_PASS: ${DB_SERVER_ZBX_PASS}"
    fi
    echo "********************"

    if [ -n "${DB_SERVER_ZBX_PASS}" ]; then
        export PGPASSWORD="${DB_SERVER_ZBX_PASS}"
    fi

    WAIT_TIMEOUT=5

    if [ "${POSTGRES_USE_IMPLICIT_SEARCH_PATH,,}" == "false" ] && [ -n "${DB_SERVER_SCHEMA}" ]; then
        PGOPTIONS="--search_path=${DB_SERVER_SCHEMA}"
        export PGOPTIONS
    fi

    if [ -n "${ZBX_DBTLSCONNECT}" ]; then
        PGSSLMODE=${ZBX_DBTLSCONNECT//_/-}
        export PGSSLMODE=${PGSSLMODE//required/require}
        export PGSSLROOTCERT=${ZBX_DBTLSCAFILE}
        export PGSSLCERT=${ZBX_DBTLSCERTFILE}
        export PGSSLKEY=${ZBX_DBTLSKEYFILE}
    fi

    while true :
    do
        psql --host ${DB_SERVER_HOST} --port ${DB_SERVER_PORT} --username ${DB_SERVER_ROOT_USER} --list --quiet 1>/dev/null 2>&1 && break
        psql --host ${DB_SERVER_HOST} --port ${DB_SERVER_PORT} --username ${DB_SERVER_ROOT_USER} --list --dbname ${DB_SERVER_DBNAME} --quiet 1>/dev/null 2>&1 && break

        echo "**** PostgreSQL server is not available. Waiting $WAIT_TIMEOUT seconds..."
        sleep $WAIT_TIMEOUT
    done

    unset PGPASSWORD
    unset PGOPTIONS
    unset PGSSLMODE
    unset PGSSLROOTCERT
    unset PGSSLCERT
    unset PGSSLKEY
}

psql_query() {
    query=$1
    db=$2

    local result=""

    if [ -n "${DB_SERVER_ZBX_PASS}" ]; then
        export PGPASSWORD="${DB_SERVER_ZBX_PASS}"
    fi

    if [ "${POSTGRES_USE_IMPLICIT_SEARCH_PATH,,}" == "false" ] && [ -n "${DB_SERVER_SCHEMA}" ]; then
        PGOPTIONS="--search_path=${DB_SERVER_SCHEMA}"
        export PGOPTIONS
    fi

    if [ -n "${ZBX_DBTLSCONNECT}" ]; then
        PGSSLMODE=${ZBX_DBTLSCONNECT//_/-}
        export PGSSLMODE=${PGSSLMODE//required/require}
        export PGSSLROOTCERT=${ZBX_DBTLSCAFILE}
        export PGSSLCERT=${ZBX_DBTLSCERTFILE}
        export PGSSLKEY=${ZBX_DBTLSKEYFILE}
    fi

    result=$(psql --no-align --quiet --tuples-only --host "${DB_SERVER_HOST}" --port "${DB_SERVER_PORT}" \
             --username "${DB_SERVER_ROOT_USER}" --command "$query" --dbname "$db" 2>/dev/null);

    unset PGPASSWORD
    unset PGOPTIONS
    unset PGSSLMODE
    unset PGSSLROOTCERT
    unset PGSSLCERT
    unset PGSSLKEY

    echo $result
}

exec_sql_file() {
    sql_script=$1

    local command="cat"

    if [ -n "${DB_SERVER_ZBX_PASS}" ]; then
        export PGPASSWORD="${DB_SERVER_ZBX_PASS}"
    fi

    if [ "${POSTGRES_USE_IMPLICIT_SEARCH_PATH,,}" == "false" ] && [ -n "${DB_SERVER_SCHEMA}" ]; then
        PGOPTIONS="--search_path=${DB_SERVER_SCHEMA}"
        export PGOPTIONS
    fi

    if [ -n "${ZBX_DBTLSCONNECT}" ]; then
        PGSSLMODE=${ZBX_DBTLSCONNECT//_/-}
        export PGSSLMODE=${PGSSLMODE//required/require}
        export PGSSLROOTCERT=${ZBX_DBTLSCAFILE}
        export PGSSLCERT=${ZBX_DBTLSCERTFILE}
        export PGSSLKEY=${ZBX_DBTLSKEYFILE}
    fi

    if [ "${sql_script: -3}" == ".gz" ]; then
        command="zcat"
    fi

    $command $sql_script | psql --quiet \
        --host "${DB_SERVER_HOST}" --port "${DB_SERVER_PORT}" \
        --username "${DB_SERVER_ZBX_USER}" --dbname "${DB_SERVER_DBNAME}" 1>/dev/null || exit 1

    unset PGPASSWORD
    unset PGOPTIONS
    unset PGSSLMODE
    unset PGSSLROOTCERT
    unset PGSSLCERT
    unset PGSSLKEY
}

create_db_database_postgresql() {
    DB_EXISTS=$(psql_query "SELECT 1 AS result FROM pg_database WHERE datname='${DB_SERVER_DBNAME}'" "${DB_SERVER_DBNAME}")

    if [ -z ${DB_EXISTS} ]; then
        echo "** Database '${DB_SERVER_DBNAME}' does not exist. Creating..."

        if [ -n "${DB_SERVER_ZBX_PASS}" ]; then
            export PGPASSWORD="${DB_SERVER_ZBX_PASS}"
        fi

        if [ "${POSTGRES_USE_IMPLICIT_SEARCH_PATH,,}" == "false" ] && [ -n "${DB_SERVER_SCHEMA}" ]; then
            PGOPTIONS="--search_path=${DB_SERVER_SCHEMA}"
            export PGOPTIONS
        fi

        if [ -n "${ZBX_DBTLSCONNECT}" ]; then
            PGSSLMODE=${ZBX_DBTLSCONNECT//_/-}
            export PGSSLMODE=${PGSSLMODE//required/require}
            export PGSSLROOTCERT=${ZBX_DBTLSCAFILE}
            export PGSSLCERT=${ZBX_DBTLSCERTFILE}
            export PGSSLKEY=${ZBX_DBTLSKEYFILE}
        fi

        createdb --host "${DB_SERVER_HOST}" --port "${DB_SERVER_PORT}" --username "${DB_SERVER_ROOT_USER}" \
                 --owner "${DB_SERVER_ZBX_USER}" --lc-ctype "en_US.utf8" --lc-collate "en_US.utf8" "${DB_SERVER_DBNAME}"

        unset PGPASSWORD
        unset PGOPTIONS
        unset PGSSLMODE
        unset PGSSLROOTCERT
        unset PGSSLCERT
        unset PGSSLKEY
    else
        echo "** Database '${DB_SERVER_DBNAME}' already exists. Please be careful with database owner!"
    fi

    psql_query "CREATE SCHEMA IF NOT EXISTS ${DB_SERVER_SCHEMA}" "${DB_SERVER_DBNAME}" 1>/dev/null
}

apply_db_scripts() {
    db_scripts=$1

    for sql_script in $db_scripts; do
        [ -e "$sql_script" ] || continue
        echo "** Processing additional '$sql_script' SQL script"

        exec_sql_file "$sql_script"
    done
}

create_db_schema_postgresql() {
    DBVERSION_TABLE_EXISTS=$(psql_query "SELECT 1 FROM pg_catalog.pg_class c JOIN pg_catalog.pg_namespace n ON n.oid = 
                                         c.relnamespace WHERE  n.nspname = '$DB_SERVER_SCHEMA' AND c.relname = 'dbversion'" "${DB_SERVER_DBNAME}")

    if [ -n "${DBVERSION_TABLE_EXISTS}" ]; then
        echo "** Table '${DB_SERVER_DBNAME}.dbversion' already exists."
        ZBX_DB_VERSION=$(psql_query "SELECT mandatory FROM ${DB_SERVER_SCHEMA}.dbversion" "${DB_SERVER_DBNAME}")
    fi

    if [ -z "${ZBX_DB_VERSION}" ]; then
        echo "** Creating '${DB_SERVER_DBNAME}' schema in PostgreSQL"

        if [ "${ENABLE_TIMESCALEDB,,}" == "true" ]; then
            psql_query "CREATE EXTENSION IF NOT EXISTS timescaledb CASCADE;" "${DB_SERVER_DBNAME}"
        fi

        exec_sql_file "/usr/share/doc/zabbix-server-postgresql/create.sql.gz"

        if [ "${ENABLE_TIMESCALEDB,,}" == "true" ]; then
            exec_sql_file "/usr/share/doc/zabbix-server-postgresql/timescaledb.sql"
        fi

        apply_db_scripts "/usr/lib/zabbix/dbscripts/*.sql"
        apply_db_scripts "/var/lib/zabbix/dbscripts/*.sql"
    fi
}

update_zbx_config() {
    local type=$1
    local db_type=$2

    echo "** Preparing Zabbix server configuration file"

    ZBX_CONFIG=$ZABBIX_ETC_DIR/zabbix_server.conf

    update_config_var $ZBX_CONFIG "ListenIP" "${ZBX_LISTENIP}"
    update_config_var $ZBX_CONFIG "ListenPort" "${ZBX_LISTENPORT}"
    update_config_var $ZBX_CONFIG "ListenBacklog" "${ZBX_LISTENBACKLOG}"

    update_config_var $ZBX_CONFIG "SourceIP" "${ZBX_SOURCEIP}"
    update_config_var $ZBX_CONFIG "LogType" "console"
    update_config_var $ZBX_CONFIG "LogFile"
    update_config_var $ZBX_CONFIG "LogFileSize"
    update_config_var $ZBX_CONFIG "PidFile"

    update_config_var $ZBX_CONFIG "DebugLevel" "${ZBX_DEBUGLEVEL}"

    if [ -n "${ZBX_DBTLSCONNECT}" ]; then
        update_config_var $ZBX_CONFIG "DBTLSConnect" "${ZBX_DBTLSCONNECT}"
        update_config_var $ZBX_CONFIG "DBTLSCAFile" "${ZBX_DBTLSCAFILE}"
        update_config_var $ZBX_CONFIG "DBTLSCertFile" "${ZBX_DBTLSCERTFILE}"
        update_config_var $ZBX_CONFIG "DBTLSKeyFile" "${ZBX_DBTLSKEYFILE}"
        update_config_var $ZBX_CONFIG "DBTLSCipher" "${ZBX_DBTLSCIPHER}"
        update_config_var $ZBX_CONFIG "DBTLSCipher13" "${ZBX_DBTLSCIPHER13}"
    fi

    update_config_var $ZBX_CONFIG "DBHost" "${DB_SERVER_HOST}"
    update_config_var $ZBX_CONFIG "DBName" "${DB_SERVER_DBNAME}"
    update_config_var $ZBX_CONFIG "DBSchema" "${DB_SERVER_SCHEMA}"
    update_config_var $ZBX_CONFIG "DBPort" "${DB_SERVER_PORT}"

    if [ -n "${ZBX_VAULTDBPATH}" ] && [ -n "${ZBX_VAULTURL}" ]; then
        update_config_var $ZBX_CONFIG "Vault" "${ZBX_VAULT}"
        update_config_var $ZBX_CONFIG "VaultDBPath" "${ZBX_VAULTDBPATH}"
        update_config_var $ZBX_CONFIG "VaultTLSCertFile" "${ZBX_VAULTTLSCERTFILE}"
        update_config_var $ZBX_CONFIG "VaultTLSKeyFile" "${ZBX_VAULTTLSKEYFILE}"
        update_config_var $ZBX_CONFIG "VaultURL" "${ZBX_VAULTURL}"
        update_config_var $ZBX_CONFIG "DBUser"
        update_config_var $ZBX_CONFIG "DBPassword"
    else
        update_config_var $ZBX_CONFIG "Vault"
        update_config_var $ZBX_CONFIG "VaultDBPath"
        update_config_var $ZBX_CONFIG "VaultTLSCertFile"
        update_config_var $ZBX_CONFIG "VaultTLSKeyFile"
        update_config_var $ZBX_CONFIG "VaultURL"
        update_config_var $ZBX_CONFIG "DBUser" "${DB_SERVER_ZBX_USER}"
        update_config_var $ZBX_CONFIG "DBPassword" "${DB_SERVER_ZBX_PASS}"
    fi

    update_config_var $ZBX_CONFIG "AllowUnsupportedDBVersions" "${ZBX_ALLOWUNSUPPORTEDDBVERSIONS}"

    update_config_var $ZBX_CONFIG "StartReportWriters" "${ZBX_STARTREPORTWRITERS}"
    : ${ZBX_WEBSERVICEURL:="http://zabbix-web-service:10053/report"}
    update_config_var $ZBX_CONFIG "WebServiceURL" "${ZBX_WEBSERVICEURL}"

    update_config_var $ZBX_CONFIG "HistoryStorageURL" "${ZBX_HISTORYSTORAGEURL}"
    update_config_var $ZBX_CONFIG "HistoryStorageTypes" "${ZBX_HISTORYSTORAGETYPES}"
    update_config_var $ZBX_CONFIG "HistoryStorageDateIndex" "${ZBX_HISTORYSTORAGEDATEINDEX}"

    update_config_var $ZBX_CONFIG "DBSocket" "${DB_SERVER_SOCKET}"

    update_config_var $ZBX_CONFIG "StatsAllowedIP" "${ZBX_STATSALLOWEDIP}"

    update_config_var $ZBX_CONFIG "StartPollers" "${ZBX_STARTPOLLERS}"
    update_config_var $ZBX_CONFIG "StartIPMIPollers" "${ZBX_IPMIPOLLERS}"
    update_config_var $ZBX_CONFIG "StartPollersUnreachable" "${ZBX_STARTPOLLERSUNREACHABLE}"
    update_config_var $ZBX_CONFIG "StartTrappers" "${ZBX_STARTTRAPPERS}"
    update_config_var $ZBX_CONFIG "StartPingers" "${ZBX_STARTPINGERS}"
    update_config_var $ZBX_CONFIG "StartDiscoverers" "${ZBX_STARTDISCOVERERS}"
    update_config_var $ZBX_CONFIG "StartHistoryPollers" "${ZBX_STARTHISTORYPOLLERS}"
    update_config_var $ZBX_CONFIG "StartHTTPPollers" "${ZBX_STARTHTTPPOLLERS}"
    update_config_var $ZBX_CONFIG "StartODBCPollers" "${ZBX_STARTODBCPOLLERS}"

    update_config_var $ZBX_CONFIG "StartConnectors" "${ZBX_STARTCONNECTORS}"
    update_config_var $ZBX_CONFIG "StartPreprocessors" "${ZBX_STARTPREPROCESSORS}"
    update_config_var $ZBX_CONFIG "StartTimers" "${ZBX_STARTTIMERS}"
    update_config_var $ZBX_CONFIG "StartEscalators" "${ZBX_STARTESCALATORS}"
    update_config_var $ZBX_CONFIG "StartAlerters" "${ZBX_STARTALERTERS}"

    update_config_var $ZBX_CONFIG "StartTimers" "${ZBX_STARTTIMERS}"
    update_config_var $ZBX_CONFIG "StartEscalators" "${ZBX_STARTESCALATORS}"

    update_config_var $ZBX_CONFIG "StartLLDProcessors" "${ZBX_STARTLLDPROCESSORS}"

    : ${ZBX_JAVAGATEWAY_ENABLE:="false"}
    if [ "${ZBX_JAVAGATEWAY_ENABLE,,}" == "true" ]; then
        update_config_var $ZBX_CONFIG "JavaGateway" "${ZBX_JAVAGATEWAY:-"zabbix-java-gateway"}"
        update_config_var $ZBX_CONFIG "JavaGatewayPort" "${ZBX_JAVAGATEWAYPORT}"
        update_config_var $ZBX_CONFIG "StartJavaPollers" "${ZBX_STARTJAVAPOLLERS:-"5"}"
    else
        update_config_var $ZBX_CONFIG "JavaGateway"
        update_config_var $ZBX_CONFIG "JavaGatewayPort"
        update_config_var $ZBX_CONFIG "StartJavaPollers"
    fi

    update_config_var $ZBX_CONFIG "StartVMwareCollectors" "${ZBX_STARTVMWARECOLLECTORS}"
    update_config_var $ZBX_CONFIG "VMwareFrequency" "${ZBX_VMWAREFREQUENCY}"
    update_config_var $ZBX_CONFIG "VMwarePerfFrequency" "${ZBX_VMWAREPERFFREQUENCY}"
    update_config_var $ZBX_CONFIG "VMwareCacheSize" "${ZBX_VMWARECACHESIZE}"
    update_config_var $ZBX_CONFIG "VMwareTimeout" "${ZBX_VMWARETIMEOUT}"

    : ${ZBX_ENABLE_SNMP_TRAPS:="false"}
    if [ "${ZBX_ENABLE_SNMP_TRAPS,,}" == "true" ]; then
        update_config_var $ZBX_CONFIG "SNMPTrapperFile" "${ZABBIX_USER_HOME_DIR}/snmptraps/snmptraps.log"
        update_config_var $ZBX_CONFIG "StartSNMPTrapper" "1"
    else
        update_config_var $ZBX_CONFIG "SNMPTrapperFile"
        update_config_var $ZBX_CONFIG "StartSNMPTrapper"
    fi

    update_config_var $ZBX_CONFIG "HousekeepingFrequency" "${ZBX_HOUSEKEEPINGFREQUENCY}"

    update_config_var $ZBX_CONFIG "MaxHousekeeperDelete" "${ZBX_MAXHOUSEKEEPERDELETE}"
    update_config_var $ZBX_CONFIG "ProblemHousekeepingFrequency" "${ZBX_PROBLEMHOUSEKEEPINGFREQUENCY}"

    update_config_var $ZBX_CONFIG "CacheSize" "${ZBX_CACHESIZE}"

    update_config_var $ZBX_CONFIG "CacheUpdateFrequency" "${ZBX_CACHEUPDATEFREQUENCY}"

    update_config_var $ZBX_CONFIG "StartDBSyncers" "${ZBX_STARTDBSYNCERS}"
    update_config_var $ZBX_CONFIG "HistoryCacheSize" "${ZBX_HISTORYCACHESIZE}"
    update_config_var $ZBX_CONFIG "HistoryIndexCacheSize" "${ZBX_HISTORYINDEXCACHESIZE}"

    update_config_var $ZBX_CONFIG "TrendCacheSize" "${ZBX_TRENDCACHESIZE}"
    update_config_var $ZBX_CONFIG "TrendFunctionCacheSize" "${ZBX_TRENDFUNCTIONCACHESIZE}"
    update_config_var $ZBX_CONFIG "ValueCacheSize" "${ZBX_VALUECACHESIZE}"

    update_config_var $ZBX_CONFIG "Timeout" "${ZBX_TIMEOUT}"
    update_config_var $ZBX_CONFIG "TrapperTimeout" "${ZBX_TRAPPERTIMEOUT}"
    update_config_var $ZBX_CONFIG "UnreachablePeriod" "${ZBX_UNREACHABLEPERIOD}"
    update_config_var $ZBX_CONFIG "UnavailableDelay" "${ZBX_UNAVAILABLEDELAY}"
    update_config_var $ZBX_CONFIG "UnreachableDelay" "${ZBX_UNREACHABLEDELAY}"

    update_config_var $ZBX_CONFIG "AlertScriptsPath" "/usr/lib/zabbix/alertscripts"
    update_config_var $ZBX_CONFIG "ExternalScripts" "/usr/lib/zabbix/externalscripts"

    if [ -n "${ZBX_EXPORTFILESIZE}" ]; then
        update_config_var $ZBX_CONFIG "ExportDir" "$ZABBIX_USER_HOME_DIR/export/"
        update_config_var $ZBX_CONFIG "ExportFileSize" "${ZBX_EXPORTFILESIZE}"
        update_config_var $ZBX_CONFIG "ExportType" "${ZBX_EXPORTTYPE}"
    fi

    update_config_var $ZBX_CONFIG "FpingLocation" "/usr/sbin/fping"
    update_config_var $ZBX_CONFIG "Fping6Location"

    update_config_var $ZBX_CONFIG "SSHKeyLocation" "$ZABBIX_USER_HOME_DIR/ssh_keys"
    update_config_var $ZBX_CONFIG "LogSlowQueries" "${ZBX_LOGSLOWQUERIES}"

    update_config_var $ZBX_CONFIG "StartProxyPollers" "${ZBX_STARTPROXYPOLLERS}"
    update_config_var $ZBX_CONFIG "ProxyConfigFrequency" "${ZBX_PROXYCONFIGFREQUENCY}"
    update_config_var $ZBX_CONFIG "ProxyDataFrequency" "${ZBX_PROXYDATAFREQUENCY}"

    update_config_var $ZBX_CONFIG "SSLCertLocation" "$ZABBIX_USER_HOME_DIR/ssl/certs/"
    update_config_var $ZBX_CONFIG "SSLKeyLocation" "$ZABBIX_USER_HOME_DIR/ssl/keys/"
    update_config_var $ZBX_CONFIG "SSLCALocation" "$ZABBIX_USER_HOME_DIR/ssl/ssl_ca/"
    update_config_var $ZBX_CONFIG "LoadModulePath" "$ZABBIX_USER_HOME_DIR/modules/"
    update_config_multiple_var $ZBX_CONFIG "LoadModule" "${ZBX_LOADMODULE}"

    update_config_var $ZBX_CONFIG "TLSCAFile" "${ZBX_TLSCAFILE}"
    update_config_var $ZBX_CONFIG "TLSCRLFile" "${ZBX_TLSCRLFILE}"

    update_config_var $ZBX_CONFIG "TLSCertFile" "${ZBX_TLSCERTFILE}"
    update_config_var $ZBX_CONFIG "TLSCipherAll" "${ZBX_TLSCIPHERALL}"
    update_config_var $ZBX_CONFIG "TLSCipherAll13" "${ZBX_TLSCIPHERALL13}"
    update_config_var $ZBX_CONFIG "TLSCipherCert" "${ZBX_TLSCIPHERCERT}"
    update_config_var $ZBX_CONFIG "TLSCipherCert13" "${ZBX_TLSCIPHERCERT13}"
    update_config_var $ZBX_CONFIG "TLSCipherPSK" "${ZBX_TLSCIPHERPSK}"
    update_config_var $ZBX_CONFIG "TLSCipherPSK13" "${ZBX_TLSCIPHERPSK13}"
    update_config_var $ZBX_CONFIG "TLSKeyFile" "${ZBX_TLSKEYFILE}"

    update_config_var $ZBX_CONFIG "TLSPSKIdentity" "${ZBX_TLSPSKIDENTITY}"
    update_config_var $ZBX_CONFIG "TLSPSKFile" "${ZBX_TLSPSKFILE}"

    update_config_var $ZBX_CONFIG "ServiceManagerSyncFrequency" "${ZBX_SERVICEMANAGERSYNCFREQUENCY}"

    if [ "${ZBX_AUTOHANODENAME}" == 'fqdn' ] && [ ! -n "${ZBX_HANODENAME}" ]; then
        update_config_var $ZBX_CONFIG "HANodeName" "$(hostname -f)"
    elif [ "${ZBX_AUTOHANODENAME}" == 'hostname' ] && [ ! -n "${ZBX_HANODENAME}" ]; then
        update_config_var $ZBX_CONFIG "HANodeName" "$(hostname)"
    else
        update_config_var $ZBX_CONFIG "HANodeName" "${ZBX_HANODENAME}"
    fi

    : ${ZBX_NODEADDRESSPORT:="10051"}
    if [ "${ZBX_AUTONODEADDRESS}" == 'fqdn' ] && [ ! -n "${ZBX_NODEADDRESS}" ]; then
        update_config_var $ZBX_CONFIG "NodeAddress" "$(hostname -f):${ZBX_NODEADDRESSPORT}"
    elif [ "${ZBX_AUTONODEADDRESS}" == 'hostname' ] && [ ! -n "${ZBX_NODEADDRESS}" ]; then
        update_config_var $ZBX_CONFIG "NodeAddress" "$(hostname):${ZBX_NODEADDRESSPORT}"
    else
        update_config_var $ZBX_CONFIG "NodeAddress" "${ZBX_NODEADDRESS}"
    fi

    if [ "$(id -u)" != '0' ]; then
        update_config_var $ZBX_CONFIG "User" "$(whoami)"
    else
        update_config_var $ZBX_CONFIG "AllowRoot" "1"
    fi
}

prepare_db() {
    echo "** Preparing database"

    check_variables_postgresql
    check_db_connect_postgresql
    create_db_database_postgresql
    create_db_schema_postgresql
}

prepare_server() {
    echo "** Preparing Zabbix server"

    prepare_db
    update_zbx_config
}

#################################################

if [ "${1#-}" != "$1" ]; then
    set -- /usr/sbin/zabbix_server "$@"
fi

if [ "$1" == '/usr/sbin/zabbix_server' ]; then
    prepare_server
fi

if [ "$1" == "init_db_only" ]; then
    prepare_db
else
    exec "$@"
fi

#################################################
