<?php
/*
1. Создать структуру классов ведения товарной номенклатуры.
а) Есть абстрактный товар.
б) Есть цифровой товар, штучный физический товар и товар на вес.
в) У каждого есть метод подсчета финальной стоимости.
г) У цифрового товара стоимость постоянная – дешевле штучного товара в два раза. У штучного товара обычная стоимость, у весового – в зависимости от продаваемого количества в килограммах. У всех формируется в конечном итоге доход с продаж.
д) Что можно вынести в абстрактный класс, наследование?
*/

abstract class Product {
	private $name;
	private $retailPrice;
	private $wholesalePrice;

	public function __construct(string $name, float $retailPrice, float $wholesalePrice) {
		$this->name = $name;	
		$this->retailPrice = $retailPrice;	
		$this->wholesalePrice = $wholesalePrice;	
	}	
	
	public function getName() : string {
		return $this->name;
	}

	public function setName(string $name) {
		$this->name = $name;
	}	
	
	public function getRetailPrice() : float {
		return $this->retailPrice;
	}

	public function setRetailPrice(float $retailPrice) {
		$this->retailPrice = $retailPrice;
	}	

	public function getWholesalePrice() : float {
		return $this->wholesalePrice;
	}

	public function setWholesalePrice(float $wholesalePrice) {
		$this->wholesailPrice = $wholesalePrice;
	}	
	
	public abstract function calculateTotalAmount() : float;
	
	public abstract function calculateRevenue() : float;
	
	public function __toString() {
		return $this->name . ', retail price: ' . $this->retailPrice . ', wholesale price: ' . $this->wholesalePrice;
	}
}

abstract class IndividualProduct extends Product {
	private $quantity;
	
	public function __construct($name, $retailPrice, $wholesalePrice, $quantity) {
		parent::__construct($name, $retailPrice, $wholesalePrice);
		
		$this->quantity = $quantity;
	}	
	
	public function getQuantity() : int {
		return $this->quantity;
	}

	public function setQuantity(int $quantity) {
		$this->quantity = $quantity;
	}
	
	public function calculateRevenue() : float {
		return $this->calculateTotalAmount() - ($this->quantity * $this->getWholesalePrice());	
	}
	
	public function __toString() {
		return parent::__toString() . ', quantity: ' . $this->getQuantity();
	}	
}

class VariableProduct extends IndividualProduct {	
	
	public function calculateTotalAmount() : float {
		
		$quantity = $this->getQuantity();
		$retailPrice = $this->getRetailPrice();
		
		if ($quantity >= 20) {
			$totalAmount = $quantity * $retailPrice * 0.80;
		} else if ($quantity >= 5 && $quantity < 20) {
			$totalAmount = $quantity * $retailPrice * 0.90;
		} else {
			$totalAmount = $quantity * $retailPrice;
		}		
		
		return $totalAmount;
	}
}

class DigitalProduct extends IndividualProduct {
	
	public function calculateTotalAmount() : float {
		return $this->getQuantity() * $this->getRetailPrice();	
	}
}

class LooseProduct extends Product {
	private $weight;
	
	public function __construct($name, $retailPrice, $wholesalePrice, $weight) {
		parent::__construct($name, $retailPrice, $wholesalePrice);
		
		$this->weight = $weight;
	}	
	
	public function getWeight() : float {
		return $this->weight;
	}

	public function setWeight(float $weight) {
		$this->weight = $weight;
	}	
	
	public function calculateTotalAmount() : float {
		
		$retailPrice = $this->getRetailPrice();
		
		if ($this->weight >= 10) {
			$totalAmount = $this->weight * $retailPrice * 0.80;
		} else if ($this->weight >= 2 && $this->weight < 10) {
			$totalAmount = $this->weight * $retailPrice * 0.90;
		} else {
			$totalAmount = $this->weight * $retailPrice;
		}		
		
		return $totalAmount;
	}
	
	public function calculateRevenue() : float {
		return $this->calculateTotalAmount() - ($this->weight * $this->getWholesalePrice());	
	}
	
	public function __toString() {
		return parent::__toString() . ', weight: ' . $this->weight;
	}
}	

$variableProduct = new VariableProduct('My Book', 250.00, 200.00, 15);
echo $variableProduct;
echo 'Total amount: ' . $variableProduct->calculateTotalAmount();
echo 'Revenue: ' . $variableProduct->calculateRevenue();

$digitalProduct = new DigitalProduct('My Software', 500.00, 400.00, 10);
echo $digitalProduct;
echo 'Total amount: ' . $digitalProduct->calculateTotalAmount();
echo 'Revenue: ' . $digitalProduct->calculateRevenue();

$looseProduct = new LooseProduct('My Potatos', 15.00, 10.00, 100.00);
echo $looseProduct;
echo 'Total amount: ' . $looseProduct->calculateTotalAmount();
echo 'Revenue: ' . $looseProduct->calculateRevenue();

/*
2. *Реализовать паттерн Singleton при помощи traits.
*/

trait SingletonTrait {
	
	private static $instance;
		
	public static function getInstance() {
		if ( empty(self::$instance) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function __construct() {}
	private function __clone() {}
	private function __wakeup() {}
}

class Singleton {
	use SingletonTrait;
	
	public function doAction() { 
		echo 'I am a Singleton!';
	}
}

class AnotherSingleton {
	use SingletonTrait;
	
	public function doAction() { 
		echo 'I am also a Singleton!';
	}
}

Singleton::getInstance()->doAction();
AnotherSingleton::getInstance()->doAction();

?>