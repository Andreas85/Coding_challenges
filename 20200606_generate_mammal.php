<?php
$debug = false;

if ($debug) {
    echo '<div style="width:500px;border:3px solid darkblue;height:500px;margin-left:auto;margin-right:auto;padding:10px;">';
    echo '<pre>';
}

class Mammal
{
    protected $gender;
    protected $hairColor;
    protected $hairLength;
    protected $height;
    protected $species;

    public function __construct() {
        $this->gender = $this->generateGender(); 
        $this->hairColor = $this->generateHairColor();
        $this->hairLength = $this->generateHairLength();
    }

    private function generateGender() {
        $genders = ['male', 'female'];
        return $genders[rand(0, count($genders) -1)];
    }

    private function generateHairColor() {
        $hairColors = ['#cccccc', '#663300', '#000000', '#990000'];
        return $hairColors[rand(0, count($hairColors) -1)];
    }

    private function generateHairLength() {
        return rand(1, 100);
    }

    private function generateHeight() {
        return rand(70, 200);
    }

    public function outputMammal() {
        echo json_encode(
            [
                'species' => $this->species,
                'gender' => $this->gender,
                'hairColor' => $this->hairColor,
                'hairLength' => $this->hairLength,
                'height' => $this->height
            ], JSON_PRETTY_PRINT
        );
    }
}

class Human extends Mammal
{
    public function __construct() {
        parent::__construct();
        $this->species = 'Human';
        $this->height = $this->generateHeight();
    }

    private function generateHeight() {
        return rand(70, 200);
    }
}

class Dog extends Mammal
{
    public function __construct() {
        parent::__construct();
        $this->species = 'Dog';
        $this->height = $this->generateHeight();
    }

    private function generateHeight() {
        return rand(30, 120);
    }
}

if (rand(0,1) == 0) {
    $mammal = new Human();
} else {
    $mammal = new Dog();
}


if ($debug) {
    echo '</div>';
}

?>
<html lang=en>
<head>
  <meta charset=utf-8>
  <title>Generate mammal</title>
<style>
  #mycanvas {
    border: 1px solid purple;
  }
  body {
    text-align: center;
    margin-top: 200px;
  }
  #debug {
    display: block;
    width: 400px;
    height: 600px;
    background: white;
    position: absolute;
    right: 0px;
    top: 150px;
    border: 3px solid gray;
    text-align: left;
  }
  .code {
	color: white;
	text-align: left;
  }
</style>
</head>

<body style="background:black">
  <canvas id="mycanvas" width="600" height="500" style="background:white"></canvas>
  <div id="debug"></div>
  <br>
  <input type="button" value="Generera om" onclick="window.location.reload()">


  <div>
<code class="code">
<pre>
class Mammal
{
    protected $gender;
    protected $hairColor;
    protected $hairLength;
    protected $height;
    protected $species;

    public function __construct() {
        $this->gender = $this->generateGender(); 
        $this->hairColor = $this->generateHairColor();
        $this->hairLength = $this->generateHairLength();
    }

    private function generateGender() {
        $genders = ['male', 'female'];
        return $genders[rand(0, count($genders) -1)];
    }

    private function generateHairColor() {
        $hairColors = ['#cccccc', '#663300', '#000000', '#990000'];
        return $hairColors[rand(0, count($hairColors) -1)];
    }

    private function generateHairLength() {
        return rand(1, 100);
    }

    private function generateHeight() {
        return rand(70, 200);
    }

    public function outputMammal() {
        echo json_encode(
            [
                'species' => $this->species,
                'gender' => $this->gender,
                'hairColor' => $this->hairColor,
                'hairLength' => $this->hairLength,
                'height' => $this->height
            ], JSON_PRETTY_PRINT
        );
    }
}

class Human extends Mammal
{
    public function __construct() {
        parent::__construct();
        $this->species = 'Human';
        $this->height = $this->generateHeight();
    }

    private function generateHeight() {
        return rand(70, 200);
    }
}

class Dog extends Mammal
{
    public function __construct() {
        parent::__construct();
        $this->species = 'Dog';
        $this->height = $this->generateHeight();
    }

    private function generateHeight() {
        return rand(30, 120);
    }
}
</pre>
</code>
  </div>

</body>

<script>
  var canvas, ctx, container;
  canvas = document.getElementById('mycanvas');
  ctx = canvas.getContext("2d");
  var debug = document.getElementById('debug');
  var intervalId;

  var centerX = canvas.width/2;
  var centerY = canvas.height/2;

  var mammal = <?php echo $mammal->outputMammal(); ?>;
  var bodyScale = 2;
 
  function init(){
    intervalId = setInterval(draw, 50); 
  }

  init();

  function drawHuman() {
    var head = {'x': centerX, 'y': centerY - 50, 'height': 40 };

    // Hair 2
    var hair = {'x': head.x, 'y': head.y, 'width': head.height* 2, 'length': mammal.hairLength};
    ctx.beginPath();
    ctx.rect(hair.x - head.height, hair.y, hair.width, hair.length);
    ctx.fillStyle = mammal.hairColor;
    ctx.fill();
    ctx.lineWidth = 2;
    ctx.strokeStyle = mammal.hairColor;
    ctx.stroke();

    // Head
    ctx.beginPath();
    ctx.arc(head.x, head.y, head.height, 0, 2 * Math.PI, false);
    ctx.fillStyle = 'white';
    ctx.fill();
    ctx.lineWidth = 2;
    ctx.strokeStyle = 'black';
    ctx.stroke();

    // Hair
    ctx.save();
    ctx.translate(canvas.width, canvas.height);
    ctx.rotate(Math.PI);
    ctx.beginPath();
    ctx.arc(head.x, head.y + 110, head.height, 0, Math.PI, false);
    ctx.closePath();
    ctx.lineWidth = 5;
    ctx.fillStyle = mammal.hairColor;
    ctx.fill();
    ctx.strokeStyle = mammal.hairColor;
    ctx.stroke();
    ctx.restore();

    // Neck
    var neck = {'x': centerX, 'y': head.y + head.height, 'width': 15, 'length': 20};
    ctx.beginPath();
    ctx.rect(centerX - neck.width / 2, neck.y, neck.width, neck.length);
    ctx.fillStyle = 'white';
    ctx.fill();
    ctx.lineWidth = 2;
    ctx.strokeStyle = 'black';
    ctx.stroke();

    var body = {'x': centerX, 'y': neck.y + neck.length, 'radius': 30}
    // Right arm
    var arm = {'x': body.x - body.radius/2, 'y': body.y + 10, 'length': 100, 'width': 20};
    ctx.beginPath();
    ctx.rect(arm.x, arm.y, -arm.length, arm.width);
    ctx.fillStyle = 'white';
    ctx.fill();
    ctx.lineWidth = 2;
    ctx.strokeStyle = 'black';
    ctx.stroke();

    // Right arm
    var arm = {'x': body.x + body.radius/2, 'y': body.y + 10, 'length': 100, 'width': 20};
    ctx.beginPath();
    ctx.rect(arm.x, arm.y, arm.length, arm.width);
    ctx.fillStyle = 'white';
    ctx.fill();
    ctx.lineWidth = 2;
    ctx.strokeStyle = 'black';
    ctx.stroke();

    // Left leg
    var leg = {'x': body.x + body.radius/2 - 10, 'y': body.y + body.radius * bodyScale * 2 - 20, 'length': 100, 'width': 20};
    ctx.beginPath();
    ctx.rect(leg.x, leg.y, leg.width, leg.length);
    ctx.fillStyle = 'white';
    ctx.fill();
    ctx.lineWidth = 2;
    ctx.strokeStyle = 'black';
    ctx.stroke();

    // Right leg
    var leg = {'x': body.x - body.radius/2 - 10, 'y': body.y + body.radius * bodyScale * 2 - 20, 'length': 100, 'width': 20};
    ctx.beginPath();
    ctx.rect(leg.x, leg.y, leg.width, leg.length);
    ctx.fillStyle = 'white';
    ctx.fill();
    ctx.lineWidth = 2;
    ctx.strokeStyle = 'black';
    ctx.stroke();

    // Body
    ctx.save(); 
    ctx.scale(1, bodyScale);
    ctx.beginPath();
    ctx.arc(body.x, body.y / bodyScale + body.radius, body.radius, 0, 2 * Math.PI, false);
    ctx.fill();
    ctx.lineWidth = 2;
    ctx.strokeStyle = 'black';
    ctx.stroke();
    ctx.restore();
  }

  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    drawHuman();

    debug.innerHTML = 
      'species: ' + mammal.species + 
      '<br>gender: ' + mammal.gender + 
      '<br>hairColor: ' + mammal.hairColor + 
      '<br>hairLength: ' + mammal.hairLength + 
      '<br>height: ' + mammal.height; 

    clearInterval(intervalId);
  }

  function stop() {
    clearInterval(intervalId);
  }
</script>
