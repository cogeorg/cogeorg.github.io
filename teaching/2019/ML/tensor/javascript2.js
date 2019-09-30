// Window Metrics
header_height = 50;
train_height = 600;
error_height = 200;
train_start = header_height;

c_width = 1200;
c_height = header_height+error_height+train_height;

// ML Metrics
let trained = false;
let hist = 0;
let model = 0;
let xs = [];
let ys = [];
let x_curve = [];
let x_c = [];
let x_vals = [];
let y_vals = [];
let y_epoch = [];
let y_epoch_2 = [];
let x_curve_2 = [];
let y_curve_2 = [];
let test_curve_2 = [];
let delta = [];
let diff = 0;
let epochs = 1000;

// FUNCTIONS
function setup() {
  myCanvas = createCanvas(c_width, c_height);


  headerBuffer = createGraphics(width,header_height);
  topBuffer = createGraphics(width,train_height);
  bottomBuffer = createGraphics(width, error_height);

  //TRAIN AND RESET BUTTONS
  train_button =     createButton('Train');
  reset_button =     createButton('Reset');
  reset_button.position(0.31*width,0.35*header_height);
  reset_button.mousePressed(reset_master);
  train_button.position(0.36*width,0.35*header_height);
  train_button.mousePressed(model_build);

  myCanvas.parent("canvas");
  train_button.parent("canvas");
  reset_button.parent("canvas");

  // PREPARE INDICES FOR PLOTTING
  for (let x = -1; x < 1; x += 0.01){
    x_c.push(x);
  }
}

function drawHeaderBuffer() {
    headerBuffer.background(255, 255, 255);
    headerBuffer.fill(0, 0, 0);
    headerBuffer.textSize(20);
    headerBuffer.text("Welcome to the Neural Network Trainer!",0,header_height*(2.7/4))
}


function drawTopBuffer() {
    topBuffer.background(0, 0, 0);
    topBuffer.fill(255, 255, 255);
    topBuffer.noStroke();
    topBuffer.textSize(10);
    topBuffer.text("This is the training window!", 0,10);
    topBuffer.text("Please place dots for the neural network to map", 0,20);
    topBuffer.text("Number of observations : " + y_vals.length, 0,train_height-10);
    //plot the clicked points
    topBuffer.stroke(255,255,255);
    topBuffer.strokeWeight(5);
    for (let i = 0; i < x_vals.length;i++){
      let px = map(x_vals[i],-1,1,0,width);
      let py = map(y_vals[i],-1,1,train_height,0);
      topBuffer.point(px,py);
    }

    //plot the model progress
    topBuffer.stroke(255,0,0);
    topBuffer.strokeWeight(2);
    topBuffer.noFill();
    if(trained == true){
      topBuffer.beginShape();
      for(let i =0; i < x_c.length;i++){
        let x = map(x_c[i],-1,1,0,width);
        let y = map(y_epoch_2[i],-1,1,train_height,0);
        topBuffer.vertex(x,y);
      }
      topBuffer.endShape();
    }

}

function drawBottomBuffer() {
    bottomBuffer.background(125, 125, 125);
    bottomBuffer.fill(255, 255, 255);
    bottomBuffer.textSize(10);
    bottomBuffer.noStroke();
    bottomBuffer.text("Plot of training error", 0, 10);

    //plot the losses
    if(trained == true){
      bottomBuffer.textSize(10);
      bottomBuffer.text("Current Error :" + Math.round(delta[delta.length-1]*10000)/100 , 0, 20);
	  bottomBuffer.text("Current Epoch :" + delta.length, 0, error_height - 10);


      //plot the error curve
      bottomBuffer.stroke(255,0,0);
      bottomBuffer.strokeWeight(3);
      bottomBuffer.beginShape();
      bottomBuffer.noFill();

      for(let i =0; i < delta.length;i++){
        let x = map(i,0,epochs,0,width);
        let y = map(delta[i],min(delta),max(delta),error_height-25,25);
        bottomBuffer.vertex(x,y);
      }
      bottomBuffer.endShape();
    }
}

function draw(){

  //Global background settings
  background(0);

  // Draw the buffers
  drawHeaderBuffer();
  drawTopBuffer();
  drawBottomBuffer();

  //Show the buffers
  image(headerBuffer, 0, 0);
  image(topBuffer, 0, train_start);
  image(bottomBuffer, 0, train_start+train_height);

  //STORE THE LINE
  if (mouseIsPressed === true) {
    if(mouseX > 0 & mouseX < width & mouseY > train_start & mouseY < train_start+train_height){
      if (trained == false) {
        let x = map(mouseX,0,width,-1,1);
        let y= map(mouseY,train_start,train_start+train_height,1,-1);
        x_vals.push(x);
        y_vals.push(y);
    }
  }
}
}
//add points to the list
// function mousePressed(){
//   if(mouseX > 0 & mouseX < width & mouseY > train_start & mouseY < train_start+train_height){
//     if (trained == false) {
//       let x = map(mouseX,0,width,-1,1);
//       let y= map(mouseY,train_start,train_start+train_height,1,-1);
//       x_vals.push(x);
//       y_vals.push(y);
//   }
//   }
// }


function reset_master(){
	try{reset()}
	catch(err){reset()}
	finally{reset()};
}

function reset(){
  console.log('reset');
  trained = false;

  //clear GPU memory
  tf.disposeVariables();
  tf.dispose(y_pred_epoch);
  tf.dispose(y_epoch);
  tf.dispose(y_pred_epoch_2);
  tf.dispose(y_epoch_2);
  tf.dispose(xs);
  tf.dispose(ys);
  tf.dispose(x_curve);
  tf.dispose(model);
  tf.dispose(hist);
  tf.dispose(y_pred_epoch_2);
  tf.dispose(y_epoch_2);

  //set variables to zero
  xs = [];
  ys = [];
  x_curve = [];
  x_vals = [];
  y_vals = [];
  y_epoch = [];
  y_epoch_2 = [];
  x_curve_2 = [];
  y_curve_2 = [];
  test_curve_2 = [];
  delta = [];
  diff = 0;
  epochs = 1000;
}

//build the model
function model_build(){

  if(trained == false){
	  //Prepare the model and layers
	  console.log("building");

	  let model = tf.sequential();
	  let optimizer = tf.train.sgd(0.2);

	  model.add(tf.layers.dense({useBias : true ,activation: 'relu', units: 200,kernelInitializer: 'VarianceScaling', inputShape: [1]}));
	  model.add(tf.layers.dense({useBias : true ,activation: 'relu', units: 200,kernelInitializer: 'VarianceScaling'}));
	  model.add(tf.layers.dense({useBias : true ,activation: 'relu', units: 200,kernelInitializer: 'VarianceScaling'}));
	  model.add(tf.layers.dense({useBias : true ,activation: 'relu', units: 200,kernelInitializer: 'VarianceScaling'}));
	  model.add(tf.layers.dense({useBias : true ,activation: 'linear', units: 1,kernelInitializer: 'VarianceScaling' }));// Prepare the model for training: Specify the loss and the optimizer.
	  model.compile({loss: 'meanSquaredError', optimizer: optimizer });

	  xs      = tf.tensor2d(x_vals,[x_vals.length,1]);
	  ys      = tf.tensor2d(y_vals,[y_vals.length,1]);
	  x_curve = tf.tensor2d(x_c,[x_c.length,1]);

	  // TRAIN THE MODEL
	  let i = 0
	  console.log("training");
	  let hist = model.fit(xs, ys, {epochs: epochs ,  callbacks: {
		  onEpochEnd: () => {
		  i = i + 1 ;

		  // make predictions
		  y_epoch=model.predict(x_curve);
		  y_pred_epoch = model.predict(xs);

		  //convert to local machine
		  y_pred_epoch_2 = y_pred_epoch.dataSync();
		  y_epoch_2 = y_epoch.dataSync();

		  //calculate error
		  diff = 0
		  for(let i =0; i < y_vals.length;i++){
			  diff = (y_vals[i] - y_pred_epoch_2[i])**2 + diff;
		  }
		  // STORE ERROR AND UPDATE PLOT
		  delta.push(diff/y_vals.length);
		  draw();
		  tf.dispose(y_pred_epoch);
		  tf.dispose(y_epoch);
		  trained = true;
		}}});
		console.log("done model")
	}
}
