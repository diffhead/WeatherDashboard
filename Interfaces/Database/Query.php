<?php namespace Interfaces\Database;

interface Query
{
    const TYPE_CREATE_TABLE = 'CREATE TABLE';
    const TYPE_DROP_TABLE   = 'DROP TABLE';
    const TYPE_SELECT_FROM  = 'SELECT';
    const TYPE_UPDATE_TABLE = 'UPDATE';
    const TYPE_DELETE_FROM  = 'DELETE FROM';
    const TYPE_INSERT_INTO  = 'INSERT INTO';

    /**
     * CREATE TABLE and DROP TABLE queries
     *
     * @param string $table - table name
     * @param array  $fieldsDefinitions = [ 
     *                   "id INT(11) NOT NULL DEFAULT 1 AUTO_INCREMENT", 
     *                   "name VARCHAR(128) NOT NULL DEFAULT ''",
     *                   "type VARCHAR(8) NOT NULL DEFAULT 'string'"
     *               ]
     *
     * @param array $primaryKeys = [ 'id', 'name' ]
     */
    public function create(string $table, array $fieldsDefinitions = [], array $primaryKeys = [], bool $ifExists = true): self;
    public function drop(string $table, bool $ifExists = true): self;

    public function select(array $fields = [ '*' ]): self;
    public function from(string $name, string $alias = _APP_EMPTY_STRING_): self;

    public function join(string $table, string $alias = '', string $type = 'left', string $on = ''): self;

    public function where(string $whereStatement): self;
    public function having(string $havingStatement): self;

    public function and(string $statement): self;
    public function or(string $statement): self;

    public function groupBy(array $groupBy): self;
    public function orderBy(string $field, string $direction = 'ASC'): self;

    public function limit(int $limit): self;
    public function offset(int $offset): self;

    public function update(string $name): self;
    public function set(string $field, string $value): self;

    public function delete(): self;

    public function insert(string $intoTable, array $fields = []): self;
    /**
     * @param array $values = [ [ 1, 2, 3 ], [ 4, 5, 6 ] ]
     */
    public function values(array $values = []): self;

    public function getString(): string;
    public function setString(string $query): void;
}
