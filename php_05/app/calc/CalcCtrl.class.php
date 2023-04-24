<?php

require_once $conf->root_path.'/lib/smarty/Smarty.class.php';
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/calc/CalcForm.class.php';
require_once $conf->root_path.'/app/calc/CalcResult.class.php';


class CalcCtrl {

	private $msgs;   //wiadomości dla widoku
	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku
	private $hide_intro; //zmienna informująca o tym czy schować intro

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->msgs = new Messages();
		$this->form = new CalcForm();
		$this->result = new CalcResult();
		$this->hide_intro = false;
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
		} else { 
			$this->hide_intro = true; //przyszły pola formularza, więc - schowaj wstęp
		}
		
		// sprawdzenie, czy potrzebne wartości zostały przekazane
		if ($this->form->kw == "") {
			$this->msgs->addError('Nie podano kwoty pożyczki');
		}
		if ($this->form->pr == "") {
			$this->msgs->addError('Nie podano oprocentowania');
		}
		if ($this->form->lt == "") {
			$this->msgs->addError('Nie podano czasu spłaty');
		}
		
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! $this->msgs->isError()) {
			
			// sprawdzenie, czy $x i $y są liczbami całkowitymi
			if (! is_numeric ( $this->form->kw )) {
				$this->msgs->addError('Kwota pożyczki nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->pr )) {
				$this->msgs->addError('Oprocentowanie nie jest liczbą całkowitą');
			}
			if (! is_numeric ( $this->form->lt )) {
				$this->msgs->addError('Czas spłaty nie jest liczbą całkowitą');
			}
		}
		
		return ! $this->msgs->isError();
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
			$this->msgs->addInfo('Parametry poprawne.');
				
			//wykonanie operacji
			$this->form->kw = intval($this->form->kw);
			$this->form->pr = intval($this->form->pr)/100;
			$this->form->lt = intval($this->form->lt);
			for($i=0;$i<$lt;$i++){
			$this->form->kw=$this->form->kw*(1+$this->form->pr);
			}
			$this->result->result = $this->form->kw/(12*$this->form->lt);
			$this->form->pr = intval($this->form->pr)*100;
			$this->msgs->addInfo('Wykonano obliczenia.');
			}
		
		$this->generateView();
	}
	
	
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){
		global $conf;
		
		$smarty = new Smarty();
		$smarty->assign('conf',$conf);
		
		$smarty->assign('page_title','Przykład 05');
		$smarty->assign('page_description','Aplikacja z jednym "punktem wejścia". Model MVC, w którym jeden główny kontroler używa różnych obiektów kontrolerów w zależności od wybranej akcji - przekazanej parametrem.');
		$smarty->assign('page_header','Kontroler główny');
				
		$smarty->assign('hide_intro',$this->hide_intro);
		
		$smarty->assign('msgs',$this->msgs);
		$smarty->assign('form',$this->form);
		$smarty->assign('res',$this->result);
		
		$smarty->display($conf->root_path.'/app/calc/CalcView.html');
	}
}
