<?php
/*
1. Придумать класс, который описывает любую сущность из предметной области интернет-магазинов: продукт, ценник, посылка и т.п.
2. Описать свойства класса из п.1 (состояние).
3. Описать поведение класса из п.1 (методы).
*/
class Product {
	private $id;
	private $name;
	private $dateFrom;
	private $dateTo;
	private $price;
	
	public function __construct($id, $name, $dateFrom, $dateTo, $price) {
		$this->id = $id;
		$this->name = $name;
		
		if ($dateFrom == null) {
			$this->dateFrom = new DateTime();
		} else {	
			$this->dateFrom = $dateFrom;
		}	
		
		if ($dateTo == null) {
			$this->dateTo = new DateTime('9999-12-31');
		} else {	
			$this->dateTo = $dateTo;
		}	
		
		$this->price = $price;
	}	
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getDateFrom() {
		return $this->dateFrom;
	}
	
	public function setDateFrom($dateFrom) {
		$this->dateFrom = $dateFrom;
	}
	
	public function getDateTo() {
		return $this->dateTo;
	}
	
	public function setDateTo($dateTo) {
		$this->dateTo = $dateTo;
	}
	
	public function getPrice() {
		return $this->price;
	}
	
	public function setPrice($price) {
		$this->price = $price;
	}
	
	public function getDescription() {
		return $this->name . ' (id ' . $this->id . '), price ' . $this->price . ', valid from ' . $this->dateFrom->format('Y-m-d') . ' to ' . $this->dateTo->format('Y-m-d');
	}	
	
	public function isValid() {
		$now = new DateTime();
		return $now >= $this->dateFrom && $now < $this->dateTo;
	}	
}	

/*
4. Придумать наследников класса из п.1. Чем они будут отличаться?
*/
class Software extends Product {
	private $version;
	private $downloadLink;
	
	public function __construct($id, $name, $dateFrom, $dateTo, $price, $version, $downloadLink) {
		parent::__construct($id, $name, $dateFrom, $dateTo, $price);
		
		$this->version = $version;
		$this->downloadLink = $downloadLink;
	}	
	
	public function getVersion() {
		return $this->version;
	}
	
	public function setVersion($version) {
		$this->version = $version;
	}
	
	public function getDownloadLink() {
		return $this->downloadLink;
	}
	
	public function setDownloadLink($downloadLink) {
		$this->downloadLink = $downloadLink;
	}
	
	public function getDescription() {
		return parent::getDescription() . ' v.' . $this->version . ', please download here: ' . $this->downloadLink;
	}
}

class Bicycle extends Product {
	public static $bicycleTypes = array('City', 'Hybrid', 'Mountain', 'Race');
	
	private $frameSize;
	private $bicycleType;
	
	public function __construct($id, $name, $dateFrom, $dateTo, $price, $frameSize, $bicycleType) {
		parent::__construct($id, $name, $dateFrom, $dateTo, $price);
		
		$this->frameSize = $frameSize;
		$this->bicycleType = $bicycleType;
	}	
	
	public function getFrameSize() {
		return $this->frameSize;
	}
	
	public function setFrameSize($frameSize) {
		$this->frameSize = $frameSize;
	}
	
	public function getBicycleType() {
		return $this->bicycleType;
	}
	
	public function setBicycleType($bicycleType) {
		$this->bicycleType = $bicycleType;
	}
	
	public function getDescription() {
		return parent::getDescription() . ' size ' . $this->frameSize . ', type ' . self::$bicycleTypes[$this->bicycleType];
	}
	
	public static function getBicycleTypes() {
		return self::$bicycleTypes;
	}	
}

$product = new Product(1, "My Product", new DateTime('2019-01-01'), new DateTime('9999-12-31'), 125);
echo $product->getDescription();

$software = new Software(2, "My Software", new DateTime('2018-05-01'), new DateTime('2020-12-31'), 2500, '5.0', 'https://mysoftware.com/download');
echo $software->getDescription();

$bicycle = new Bicycle(3, "My Bicycle", new DateTime('2018-12-20'), null, 10500, '18"', 0);
echo $bicycle->getDescription();

var_dump(Bicycle::getBicycleTypes());

/*
5. Дан код:
class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
$a1 = new A();
$a2 = new A();
$a1->foo();
$a2->foo();
$a1->foo();
$a2->foo();
Что он выведет на каждом шаге? Почему?


Код выведет 1234
Переменная $x принадлежит классу, а не экземляру класса. Вызов метода foo() для любого экземляра класса A будет увеличивать значение одной и той же переменной $x на единицу.
*/

/*
Немного изменим п.5:
class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
class B extends A {
}
$a1 = new A();
$b1 = new B();
$a1->foo(); 
$b1->foo(); 
$a1->foo(); 
$b1->foo();
6. Объясните результаты в этом случае.


Код выведет 1122
Переменная $x принадлежит классу, а не экземляру класса. Вызов метода foo() для любого экземляра класса A будет увеличивать значение переменной $x из класса A на единицу, а вызов метода foo() для любого экземляра класса B будет увеличивать значение переменной $x из класса B на единицу.
*/

/*
7. *Дан код:
class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
class B extends A {
}
$a1 = new A;
$b1 = new B;
$a1->foo(); 
$b1->foo(); 
$a1->foo(); 
$b1->foo(); 
Что он выведет на каждом шаге? Почему?


Код выведет 1122. Код не отличается от п.6 за исключением отсутствия скобок после "new A" и "new B".
*/

?>