<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\lib\Database\DB;
use App\lib\Database\Database;


// Select Table


final class QueryBuilderTest extends TestCase
{
    public function setUp():void {
        $this->loadConfig = require_once '../app/config/config.php';
        $this->dbMock = $this->getMockBuilder(Database::class)->getMock();
    }

    public function test_a_table_can_be_selected(): void {
         $QB = new DB($this->dbMock);
         $tableName = 'mytable';
         $QB->table($tableName);

         $this->assertEquals($QB->table, $tableName);
    }

    // public function test_a_column_can_be_selected(): void {
    //      $QB = new DB($this->dbMock);
    //      $QB->table = 'mytable';
    //      $QB->select(['*']);
         
    //      $this->assertEquals($QB->query, $tableName);
    // }

    //INSERT INTO testtable (name, lastname, age) VALUES (:fname, :sname, :age)
    // public function test_a_record_can_be_created(): void {
    //     $QB = new DB($this->dbMock);
    //     $QB->table = 'mytable';
    //     $values = [
    //         'title' => 'new post'
    //     ];
    //     $QB->create($values);
    //     $expectedQuery = "INSERT INTO `posts` (`id`, `title`) VALUES ('1111', 'zzz')";
    //     $this->assertEquals($QB->query, 'eee');
    // }

    public function test_an_update_query_can_be_created(): void {
         $QB = new DB($this->dbMock);
         $QB->table('mytable');
         $newTitle  = 'myTitle';
         $QB->update([
            'title' => $newTitle
         ]);
         $bindedTitle = ':title';
         $this->assertEquals($QB->query, 'UPDATE mytable SET title=:title');
         $this->assertTrue(is_array($QB->bindedValues));
         $this->assertArrayHasKey($bindedTitle, $QB->bindedValues);
    }

}
