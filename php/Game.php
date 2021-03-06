<?php
function echoln($string) {
  echo $string."\n";
}

class Game {
    var $players;
    var $places;
    var $purses ;
    var $inPenaltyBox ;

    var $popQuestions;
    var $scienceQuestions;
    var $sportsQuestions;
    var $rockQuestions;
    var $culturalQuestions;
    var $currentPlayer = 0;
    var $isGettingOutOfPenaltyBox;

    function  __construct(){

   		$this->players = array();
        $this->places = array(0);
        $this->purses  = array(0);
        $this->inPenaltyBox  = array(0);

        $this->popQuestions = array();
        $this->scienceQuestions = array();
        $this->sportsQuestions = array();
        $this->rockQuestions = array();
        $this->culturalQuestions = array();

        for ($i = 0; $i < 50; $i++) {
			array_push($this->popQuestions, "Pop Question " . $i);
			array_push($this->scienceQuestions, "Science Question " . $i);
			array_push($this->sportsQuestions, "Sports Question " . $i);
			array_push($this->rockQuestions, "Rock Question " . $i);
			array_push($this->culturalQuestions, "Cultural Question " . $i);

    	}
    }

	

	function isPlayable() {
		return ($this->howManyPlayers() >= 2);
	}

	function add($playerName) {
	   array_push($this->players, $playerName);
	   $this->places[$this->howManyPlayers()] = 0;
	   $this->purses[$this->howManyPlayers()] = 0;
	   $this->inPenaltyBox[$this->howManyPlayers()] = false;

	    echoln($playerName . " was added");
	    echoln("They are player number " . count($this->players));
		return true;
	}

	function howManyPlayers() {
		return count($this->players);
	}

	function  roll($roll) {
		echoln($this->players[$this->currentPlayer] . " is the current player");
		echoln("They have rolled a " . $roll);

		if ($this->inPenaltyBox[$this->currentPlayer]) {
			if ($roll % 2 != 0) {
				$this->isGettingOutOfPenaltyBox = true;

				echoln($this->players[$this->currentPlayer] . " is getting out of the penalty box");
				$this->updatePlaceAndAskQuestion($roll);
			} else {
				echoln($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
				$this->isGettingOutOfPenaltyBox = false;
				}

		} else {

			$this->updatePlaceAndAskQuestion($roll);
		}

	}

	function updatePlaceAndAskQuestion($roll){
			$this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
			if ($this->places[$this->currentPlayer] > 11) $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;

			echoln($this->players[$this->currentPlayer]
					. "'s new location is "
					.$this->places[$this->currentPlayer]);
			echoln("The category is " . $this->currentCategory());
			$this->askQuestion();
	}

	function  askQuestion() {
		if ($this->currentCategory() == "Pop")
			echoln(array_shift($this->popQuestions));
		if ($this->currentCategory() == "Science")
			echoln(array_shift($this->scienceQuestions));
		if ($this->currentCategory() == "Sports")
			echoln(array_shift($this->sportsQuestions));
		if ($this->currentCategory() == "Rock")
			echoln(array_shift($this->rockQuestions));
		if ($this->currentCategory() == "Cultural")
			echoln(array_shift($this->culturalQuestions));
	}


	function currentCategory() {
		if ($this->places[$this->currentPlayer] == 0) return "Pop";
		if ($this->places[$this->currentPlayer] == 4) return "Pop";
		if ($this->places[$this->currentPlayer] == 8) return "Pop";
		if ($this->places[$this->currentPlayer] == 1) return "Science";
		if ($this->places[$this->currentPlayer] == 5) return "Science";
		if ($this->places[$this->currentPlayer] == 9) return "Cultural";
		if ($this->places[$this->currentPlayer] == 2) return "Sports";
		if ($this->places[$this->currentPlayer] == 6) return "Sports";
		if ($this->places[$this->currentPlayer] == 10) return "Cultural";
		return "Rock";
	}

	function wasCorrectlyAnswered() {
		if ($this->inPenaltyBox[$this->currentPlayer]){
			if ($this->isGettingOutOfPenaltyBox) {
				echoln("Answer was correct!!!!");

				$winner = $this->updateStatus();
				$this->updateCurrentPlayer();

				return $winner;
			} else {
				$this->updateCurrentPlayer();
				return true;
			}



		} else {

			echoln("Answer was corrent!!!!");

			$winner = $this->updateStatus();
			$this->updateCurrentPlayer();

			return $winner;
		}
	}

	function updateStatus(){
		$this->purses[$this->currentPlayer]++;
		echoln($this->players[$this->currentPlayer]
						. " now has "
						.$this->purses[$this->currentPlayer]
						. " Gold Coins.");

		return $this->didPlayerWin();
	}
	function updateCurrentPlayer(){
			$this->currentPlayer++;
			if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;
	}

	function wrongAnswer(){
		echoln("Question was incorrectly answered");
		echoln($this->players[$this->currentPlayer] . " was sent to the penalty box");
		$this->inPenaltyBox[$this->currentPlayer] = true;

		$this->updateCurrentPlayer();

		return true;
	}


	function didPlayerWin() {
		return !($this->purses[$this->currentPlayer] == 6);
	}
}
