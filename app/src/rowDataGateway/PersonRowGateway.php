<?php

declare(strict_types=1);

namespace Root\App\rowDataGateway;

use Exception;
use PDO;
use Root\App\tableGateway\PersonTableGatewayDto;

class PersonRowGateway extends PersonTableGatewayDto
{
    private PDO $pdo;
    static private string $table = 'person';

    /**
     * @throws Exception
     */
    public function __construct(PDO $pdo, ?string $id = null)
    {
        $this->pdo = $pdo;
        if (!empty($id)) {
            $this->findById($id);
        }
    }

    /**
     * @throws Exception
     */
    public function insert(): void
    {
        /** @noinspection PhpArrayIndexImmediatelyRewrittenInspection */
        $columns = ['id' => null, 'add_timestamp' => null, 'fam' => null, 'nam' => null, 'otc' => null,
            'birthday' => null, 'nom' => null, 'prenom' => null, 'sex' => null];
        if (empty($this->id)) {
            unset($columns['id']);
        } else {
            $columns['id'] = $this->id;
        }
        if (empty($this->addTimestamp)) {
            unset($columns['add_timestamp']);
        } else {
            $columns['add_timestamp'] = $this->addTimestamp->format('Y-m-d.u');
        }
        $columns['fam'] = $this->fam;
        $columns['nam'] = $this->nam;
        $columns['otc'] = $this->otc;
        $columns['birthday'] = $this->birthday?->format('Y-m-d');
        $columns['nom'] = $this->nom;
        $columns['prenom'] = $this->prenom;
        $columns['sex'] = $this->sex->value;

        /** @noinspection SqlResolve */
        $sql = 'INSERT INTO ' . self::$table . ' (' . implode(',', array_keys($columns)) . ') VALUES (' . implode(',', array_pad([], count($columns), '?')) . ') RETURNING id, add_timestamp';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array_values($columns));
        $result = $statement->fetch();
        if (empty($result)) {
            throw new Exception('Error insert person');
        }
        $this->setId($result['id'] ?? null);
        $this->setAddTimestamp($result['add_timestamp'] ?? null);
    }

    /**
     * @throws Exception
     */
    public function update(): void
    {
        if (empty($this->id)) {
            throw new Exception('Error update person');
        }

        $columns = ['fam' => $this->fam, 'nam' => $this->nam, 'otc' => $this->otc,
            'birthday' => $this->birthday?->format('Y-m-d'), 'nom' => $this->nom, 'prenom' => $this->prenom,
            'sex' => $this->sex->value];
        $sqlSet = [];
        foreach ($columns as $key => $value) {
            /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
            $sqlSet[] = "{$key} = ?";
        }

        $sql = 'UPDATE ' . self::$table . ' SET ' . implode(',', $sqlSet) . ' WHERE id = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([...array_values($columns), $this->id]);
    }

    /**
     * @return PersonRowGateway[]
     * @throws Exception
     */
    static public function getAll(PDO $pdo): array
    {
        $sql = 'select * from ' . self::$table;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        if (empty($result)) {
            return [];
        }

        $persons = [];
        foreach ($result as $row) {
            $persons[] = (new PersonRowGateway($pdo))
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
     * @return PersonRowGateway[]
     * @throws Exception
     */
    static public function findByFamNamOtc(PDO $pdo, string $fam, ?string $nam = null, ?string $otc = null): array
    {
        /** @noinspection SqlResolve */
        $sql = 'select * from ' . self::$table . ' where fam = ?';
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
        $statement = $pdo->prepare($sql);
        $statement->execute($execWhere);
        $result = $statement->fetchAll();
        if (empty($result)) {
            return [];
        }

        $persons = [];
        foreach ($result as $row) {
            $persons[] = (new PersonRowGateway($pdo))
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
    private function findById(string $id): void
    {
        /** @noinspection SqlResolve */
        $sql = 'select * from ' . self::$table . ' where id = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$id]);
        $result = $statement->fetch();
        if (!empty($result)) {
            $this->setId($result['id']);
            $this->setAddTimestamp($result['add_timestamp']);
            $this->setFam($result['fam']);
            $this->setNam($result['nam']);
            $this->setOtc($result['otc']);
            $this->setBirthday($result['birthday']);
            $this->setNom($result['nom']);
            $this->setPrenom($result['prenom']);
            $this->setSex($result['sex']);
        }
    }
}
