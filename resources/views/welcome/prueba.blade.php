<<?php
use PHPUnit\Framework\TestCase;

class ExpectedErrorTest extends TestCase
{
    /**
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function testFailingInclude()
    {
        include 'not_existing_file.php';
    }
}
    function test($php_code, $ex) { //5
      if( PHP_MAJOR_VERSION == 5 ){ //4
        try { eval($php_code); }
        catch(Exception $e) { //5
          if(get_class($e) === $ex )
            return;
          else
            throw new RuntimeException("test failed:"
              . "\ngot: ". get_class($e)
              . "\nexp: $ex"
              . "\ndetails: $e");
        } //5
      }//4
      else if( PHP_MAJOR_VERSION == 7 ){ //1
        try { eval($php_code); }
        catch(Throwable $e) {//2
          if(get_class($e) === $ex )
            return;
          else
          { //#
            $e = new RuntimeException("test failed:"
              . "\ngot: ". get_class($e)
              . "\nexp: $ex"
              . "\ndetails: $e");
            echo "===> $e\n";
            return;
          } //3
      } //2
    }  //1
  }//5
?>