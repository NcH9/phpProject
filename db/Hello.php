<?

trait HelloTrait1 {
    public function sayHello() {
        return "Hello Backend World! ";
    }
}
trait HelloTrait2 {
    public function sayHello() {
        return "It`s php project!";
    }
}
class MyClass {
    use HelloTrait1, HelloTrait2 {
        HelloTrait1::sayHello insteadof HelloTrait2;
        HelloTrait2::sayHello as sayHelloPart2;
    }

    public function greet() {
        return $this->sayHello().$this->sayHelloPart2();
    }
}

?>