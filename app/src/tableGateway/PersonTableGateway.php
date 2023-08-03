<?php

declare(strict_types=1);

namespace Root\App\tableGateway;

use Exception;
use PDO;

class PersonTableGateway
{
    private PDO $pdo;
    private string $table = 'person';


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws Exception
     */
    public function findById(string $id): ?PersonTableGatewayDto
    {
        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection, SqlResolve */
        $sql = "select * from {$this->table} where id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$id]);
        $result = $statement->fetch();
        if (empty($result)) {
            return null;
        }

        return (new PersonTableGatewayDto())
            ->setId($result['id'])
            ->setAddTimestamp($result['add_timestamp'])
            ->setFam($result['fam'])
            ->setNam($result['nam'])
            ->setOtc($result['otc'])
            ->setBirthday($result['birthday'])
            ->setNom($result['nom'])
            ->setPrenom($result['prenom'])
            ->setSex($result['sex']);
    }

    /**
     * @return PersonTableGatewayDto[]
     * @throws Exception
     */
    public function findByFamNamOtc(string $fam, ?string $nam = null, ?string $otc = null): array
    {
        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection, SqlResolve */
        $sql = "select * from {$this->table} where fam = ?";
        $sqlWhere = [];
        $execWhere = [$fam];
        if (!empty($nam)) {
            $sqlWhere[] = 'nam = ?';
            $execWhere[] = $nam;
        }
        if (!empty($otc)) {
            $sqlWhere[] = 'otc = ?';
            $execWhere[] = $otc;
        }

        if (!empty($sqlWhere)) {
            $sql .= ' AND ' . implode(' AND ', $sqlWhere);
        }
        $statement = $this->pdo->prepare($sql);
        $statement->execute($execWhere);
        $result = $statement->fetchAll();
        if (empty($result)) {
            return [];
        }

        $persons = [];
        foreach ($result as $row) {
            $persons[] = (new PersonTableGatewayDto())
                ->setId($row['id'])
                ->setAddTimestamp($row['add_timestamp'])
                ->setFam($row['fam'])
                ->setNam($row['nam'])
                ->setOtc($row['otc'])
                ->setBirthday($row['birthday'])
                ->setNom($row['nom'])
                ->setPrenom($row['prenom'])
                ->setSex($row['sex']);
        }
        return $persons;
    }

    /**
     * @return PersonTableGatewayDto[]
     * @throws Exception
     */
    public function getAll(): array
    {
        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
        $sql = "select * from {$this->table}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        if (empty($result)) {
            return [];
        }

        $persons = [];
        foreach ($result as $row) {
            $persons[] = (new PersonTableGatewayDto())
                ->setId($row['id'])
                ->setAddTimestamp($row['add_timestamp'])
                ->setFam($row['fam'])
                ->setNam($row['nam'])
                ->setOtc($row['otc'])
                ->setBirthday($row['birthday'])
                ->setNom($row['nom'])
                ->setPrenom($row['prenom'])
                ->setSex($row['sex']);
        }
        return $persons;
    }

    /**
     * @throws Exception
     */
    public function insert(PersonTableGatewayDto $person): PersonTableGatewayDto
    {
        /** @noinspection PhpArrayIndexImmediatelyRewrittenInspection */
        $columns = ['id' => null, 'add_timestamp' => null, 'fam' => null, 'nam' => null, 'otc' => null,
            'birthday' => null, 'nom' => null, 'prenom' => null, 'sex' => null];
        if (empty($person->id)) {
            unset($columns['id']);
        } else {
            $columns['id'] = $person->id;
        }
        if (empty($person->addTimestamp)) {
            unset($columns['add_timestamp']);
        } else {
            $columns['add_timestamp'] = $person->addTimestamp->format('Y-m-d.u');
        }
        $columns['fam'] = $person->fam;
        $columns['nam'] = $person->nam;
        $columns['otc'] = $person->otc;
        $columns['birthday'] = $person->birthday?->format('Y-m-d');
        $columns['nom'] = $person->nom;
        $columns['prenom'] = $person->prenom;
        $columns['sex'] = $person->sex->value;

        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection, SqlResolve */
        $sql = "INSERT INTO {$this->table} (" . implode(',', array_keys($columns)) . ') VALUES (' . implode(',', array_pad([], count($columns), '?')) . ') RETURNING id, add_timestamp';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array_values($columns));
        $result = $statement->fetch();
        if (empty($result)) {
            throw new Exception('Error insert person');
        }
        return $person->setId($result['id'] ?? null)
            ->setAddTimestamp($result['add_timestamp'] ?? null);
    }

    /**
     * @throws Exception
     */
    public function update(PersonTableGatewayDto $person): PersonTableGatewayDto
    {
        if (empty($person->id)) {
            throw new Exception('Error update person');
        }

        $columns = ['fam' => $person->fam, 'nam' => $person->nam, 'otc' => $person->otc,
            'birthday' => $person->birthday?->format('Y-m-d'), 'nom' => $person->nom, 'prenom' => $person->prenom,
            'sex' => $person->sex->value];
        $sqlSet = [];
        foreach ($columns as $key => $value) {
            /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
            $sqlSet[] = "{$key} = ?";
        }

        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection, SqlResolve */
        $sql = "UPDATE {$this->table} SET " . implode(',', $sqlSet) . ' WHERE id = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([...array_values($columns), $person->id]);
        return $person;
    }
}
