<?php
namespace app\controllers;

//zamieniamy zatem 'require' na 'use' wskazując jedynie przestrzeń nazw, w której znajduje się klasa
use app\forms\CalcForm;
use app\transfer\CalcResult;


class CalcCtrl {

	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->form = new CalcForm();
		$this->result = new CalcResult();
	}

	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->kw = isset($_REQUEST ['kw']) ? $_REQUEST ['kw'] : null;
		$this->form->pr = isset($_REQUEST ['pr']) ? $_REQUEST ['pr'] : null;
		$this->form->lt = isset($_REQUEST ['lt']) ? $_REQUEST ['lt'] : null;
	}

	/** 
	 * Walidacja parametrów
	 * @return true jeśli brak błedów, false w przeciwnym wypadku 
	 */
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
		if (! (isset ( $this->form->kw ) && isset ( $this->form->pr ) && isset ( $this->form->lt ))) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false; //zakończ walidację z błędem
		}

		// sprawdzenie, czy potrzebne wartości zostały przekazane
		if ($this->form->kw == "") {
			getMessages()->addError('Nie podano kwoty pożyczki');
		}
		if ($this->form->pr == "") {
			getMessages()->addError('Nie podano oprocentowania');
		}
		if ($this->form->lt == "") {
			getMessages()->addError('Nie podano czasu spłaty');
		}

		// nie ma sensu walidować dalej gdy brak parametrów
		if (! getMessages()->isError()) {

			// sprawdzenie, czy $x i $y są liczbami całkowitymi
			if (! is_numeric ( $this->form->kw )) {
				getMessages()->addError('Kwota pożyczki nie jest liczbą całkowitą');
			}

			if (! is_numeric ( $this->form->pr )) {
				getMessages()->addError('Oprocentowanie nie jest liczbą całkowitą');
			}
			if (! is_numeric ( $this->form->lt )) {
				getMessages()->addError('Czas spłaty nie jest liczbą całkowitą');
			}
		}

		return ! getMessages()->isError();
	}

	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function process(){

		$this->getparams();

		if ($this->validate()) {

			//konwersja parametrów na int
			$this->form->kw = intval($this->form->kw);
			$this->form->pr = intval($this->form->pr);
			$this->form->lt = intval($this->form->lt);
			getMessages()->addInfo('Parametry poprawne.');

			//wykonanie operacji
			$this->form->kw = intval($this->form->kw);
			$this->form->pr = intval($this->form->pr)/100;
			$this->form->lt = intval($this->form->lt);
			for($i=0;$i<$lt;$i++){
			$this->form->kw=$this->form->kw*(1+$this->form->pr);
			}
			$this->result->result = $this->form->kw/(12*$this->form->lt);
			$this->form->pr = intval($this->form->pr)*100;
			getMessages()->addInfo('Wykonano obliczenia.');
			}

		$this->generateView();
	}


	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){
		//nie trzeba już tworzyć Smarty i przekazywać mu konfiguracji i messages
		// - wszystko załatwia funkcja getSmarty()
		
		getSmarty()->assign('page_title','SUPER KALKULATOR');
		getSmarty()->assign('page_description','policz swoją ratę');
		getSmarty()->assign('page_header','Kontroler główny');
					
		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('CalcView.html'); // już nie podajemy pełnej ścieżki - foldery widoków są zdefiniowane przy ładowaniu Smarty
	}
}