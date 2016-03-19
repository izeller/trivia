<?php 
include __DIR__.'/Game.php'; 

class GameTest extends PHPUnit_Framework_TestCase
{
    var $game;
    
    public function setUp() {
       $this->game = new Game();
       $this->game->add("Chet");
       $this->game->add("Pat");
     }

     public function tearDown() {
       $this->game = null;
     }
    
  
    /**
     * @test
     */
    public function wrongAnswer_update_current_player_and_put_in_penalty_box()
    {
    

        $this->assertEquals(2, count($this->game->players));
        $this->assertEquals(0, $this->game->currentPlayer);
    
        $this->game->wrongAnswer();

        $this->assertEquals(1, $this->game->currentPlayer);
        $this->assertTrue($this->game->inPenaltyBox[0]);
         
    }

    /**
     * @test
     */
    public function if_player_was_in_penalty_and_correctAnswer()
    {

        $this->game->inPenaltyBox[0] = true;
        $this->assertEquals(0, $this->game->currentPlayer);
        $this->assertEquals(2, count($this->game->players));
    
        $notAWinner = $this->game->wasCorrectlyAnswered();

        $this->assertEquals(1,  $this->game->currentPlayer);
        $this->assertTrue($notAWinner);
        
    }

    /**
     * @test
     */
    public function if_player_was_not_in_penalty_box_and_it_is_not_getting_out()
    {

        $this->game->inPenaltyBox[0] = false;
        $this->game->isGettingOutOfPenaltyBox = false;
        $this->assertEquals(0, $this->game->currentPlayer);
        $this->assertEquals(2, count($this->game->players));
       
    
        $notAWinner = $this->game->wasCorrectlyAnswered();

      //  $this->assertEquals(0, $this->game->purses[0]);
        $this->assertEquals(1,  $this->game->currentPlayer);
        $this->assertTrue($notAWinner);
            
    }

    /**
     * @test
     */
    public function if_player_was_not_in_penalty_box_and_it_is_getting_out()
    {

        $this->game->inPenaltyBox[0] = false;

        $this->assertEquals(0, $this->game->currentPlayer);
        $this->assertEquals(2, count($this->game->players));
        $this->game->isGettingOutOfPenaltyBox = true;
               
        $notAWinner = $this->game->wasCorrectlyAnswered();

        $this->assertEquals(1, $this->game->purses[0]);
        $this->assertEquals(1,  $this->game->currentPlayer);
        $this->assertTrue($notAWinner);
            
    }

}
?>