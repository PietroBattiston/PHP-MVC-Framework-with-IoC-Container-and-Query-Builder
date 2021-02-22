<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\lib\Database\DB;
use App\lib\Database\Database;




final class QueryBuilderTest extends TestCase
{
    public function setUp():void {
        //$this->dbMock = $this->getMockBuilder('App\lib\Database\Database')->setMethods(['foo'])->getMock();

        $this->dbMock = $this->createMock(Database::class);

        $this->tableName = 'myTable';
    }

    public function test_a_table_can_be_selected(): void
    {
         $QB = new DB($this->dbMock);
         $QB->table($this->tableName);

         $this->assertEquals($QB->table, $this->tableName);
    }

    public function test_CREATE_query_can_be_built(): void
    {
        $QB = new DB($this->dbMock);
        $QB->table = $this->tableName;
        $values = [
            'title' => 'new post'
        ];
        $bindedTitle = ':title';
        $QB->create($values);
        $expectedQuery = "INSERT INTO " .$this->tableName . " (title) VALUES (:title)";
        $this->assertEquals($QB->query, $expectedQuery);
        $this->assertTrue(is_array($QB->bindedValues));
        $this->assertArrayHasKey($bindedTitle, $QB->bindedValues);
        $this->assertTrue(empty($QB->dbMethod));

    }

    public function test_CREATE_query_can_be_built_with_multiple_params(): void
    {
        $QB = new DB($this->dbMock);
        $QB->table = $this->tableName;
        $values = [
            'title' => 'new post',
            'id' => 32
        ];
        $bindedTitle = ':title';
        $bindedId = ':id';
        $QB->create($values);
        $expectedQuery = "INSERT INTO " .$this->tableName . " (title,id) VALUES (:title,:id)";
        $this->assertEquals($QB->query, $expectedQuery);
        $this->assertTrue(is_array($QB->bindedValues));
        $this->assertArrayHasKey($bindedTitle, $QB->bindedValues);
        $this->assertArrayHasKey($bindedId, $QB->bindedValues);
        $this->assertTrue(empty($QB->dbMethod));


    }

    public function test_UPDATE_query_can_be_built(): void
    {
         $QB = new DB($this->dbMock);
         $QB->table = $this->tableName;
         $this->dbMock
                ->expects($this->once())
                ->method("execute")
                ->willReturn(1);
         $newTitle  = 'myTitle';
         $QB->update([
            'title' => $newTitle
         ]);
         $bindedTitle = ':title';
         $expectedQuery =  'UPDATE ' .$this->tableName . ' SET title=:title';
         $this->assertEquals($QB->query, $expectedQuery);
         $this->assertTrue(is_array($QB->bindedValues));
         $this->assertArrayHasKey($bindedTitle, $QB->bindedValues);
         $this->assertTrue(empty($QB->dbMethod));

    }

    public function test_UPDATE_query_must_contains_multiple_binded_elements_divided_by_a_comma(): void
    {

         $QB = new DB($this->dbMock);
         $QB->table = $this->tableName;
         $this->dbMock
                ->expects($this->once())
                ->method("execute")
                ->willReturn(1);

         $newTitle  = 'myTitle';
         $QB->update([
            'title' => $newTitle,
            'id' => 32
         ]);
         $bindedTitle = ':title';
         $bindedId = ':id';
         $expectedQuery = 'UPDATE ' . $this->tableName . ' SET title=:title,id=:id';
         $this->assertEquals($QB->query, $expectedQuery);
         $this->assertArrayHasKey($bindedTitle, $QB->bindedValues);
         $this->assertArrayHasKey($bindedId, $QB->bindedValues);
         $this->assertTrue(empty($QB->dbMethod));

    }

    public function test_DELETE_query_can_be_built(): void
    {
         $QB = new DB($this->dbMock);
         $QB->table = $this->tableName;
         $this->dbMock
                ->expects($this->once())
                ->method("execute")
                ->willReturn(1);
         $QB->delete();
         $expectedQuery = 'DELETE FROM ' . $this->tableName;
         $this->assertEquals($QB->query, $expectedQuery);
         $this->assertTrue(empty($QB->dbMethod));

    }

    public function test_WHERE_clause_can_be_built(): void
    {
         $QB = new DB($this->dbMock);
         $QB->table = $this->tableName;
         $QB->where('id', '=', 32);
         $expectedQuery = ' WHERE id=:id';
         $this->assertEquals($QB->query, $expectedQuery);
    }

    public function test_multiple_WHERE_clauses_must_be_separated_by_AND(): void
    {
         $QB = new DB($this->dbMock);
         $QB->table = $this->tableName;
         $QB->where('id', '=', 32);
         $QB->where('title', '=', 'title');
         $expectedQuery = ' WHERE id=:id AND title=:title';
         $this->assertEquals($QB->query, $expectedQuery);
    }

    public function test_column_can_be_selected(): void {
         $QB = new DB($this->dbMock);
         $QB->table = $this->tableName;
         $QB->select(['title']);
         $expectedQuery = 'SELECT title FROM ' . $this->tableName;
         $this->assertEquals($QB->query, $expectedQuery);
    }

    public function test_selecting_multiple_column_must_return_col_separated_by_comma(): void
    {
         $QB = new DB($this->dbMock);
         $QB->table = $this->tableName;
         $QB->select(['title, id']);
         $expectedQuery = 'SELECT title, id FROM ' . $this->tableName;
         $this->assertEquals($QB->query, $expectedQuery);
    }

    public function test_LIMIT_clause_can_be_built(): void
    {
         $QB = new DB($this->dbMock);
         $QB->limit(2);
         $expectedQuery = ' LIMIT 2';
         $this->assertEquals($QB->query, $expectedQuery);
    }

    // public function test_calling_Get_Method_must_set_the_var_dbMethod(): void {
    //      $QB = new DB($this->dbMock);
    //      $QB->get();
    //      $this->assertEquals($QB->dbMethod, 'get');
    // }

    // public function test_calling_First_Method_must_set_the_var_dbMethod(): void {
    //      $QB = new DB($this->dbMock);
    //      $QB->first();
    //      $this->assertEquals($QB->dbMethod, 'first');
    // }
    // public function test_replacePlaceholders(): void {
    //      $QB = new DB($this->dbMock);
    //      $query = "Hello @name today is @day";
    //      $array = [
    //         "@name" => 'pietro',
    //         "@day" => 'saturday'
    //      ];
    //      $expectedQuery = "Hello pietro today is saturday";
    //      $replace = $QB->replacePlaceholders($query, $array);
    //      $this->assertEquals($replace, $expectedQuery);
    // }

}
