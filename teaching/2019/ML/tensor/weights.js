//set inputs
var s2_modelNN;
var s2_hist;
var s2_s2_y_unmapped;
var s2_y;
var s2_x;
var s2_y_predict;
var s2_y_temp;
var s2_x_temp;
let s2_trained = false;
let s2_traincount = 0;
let s2_x_vals = [0,1];
let s2_y_vals = [0,1];
let s2_x_c = [];
for(i=0;i<=1;i=i+0.01){
  s2_x_c.push(i);
}

//canvas input
s2_c_width  = 1200;
s2_c_height = 800;

//create storage structure
var dict = {};
dict[3] = [];
dict[4] = [];
dict[5] = [];
dict[6] = [];
dict[7] = [];
dict[8] = [];
dict[9] = [];
dict[10] = [];
dict[11] = [];

// storage structure for bottom equation
var biases = {};
biases["W11"] = 0;
biases["B1"] = 0;
biases["W21"] = 0;
biases["B2"] = 0;
biases["W31"] = 0;
biases["W32"] = 0;
biases["B3"] = 0;

//setup the ms2_yCanvas
function setup() {

  //CALL CORE FUNCTIONS
  createModel();
  myCanvas = createCanvas(s2_c_width, s2_c_height);

  //s2_train AND RESET BUTTONS
  train_button =     createButton('Train 1 Epoch');
  reset_button =     createButton('Reset');
  reset_button.position(s2_c_width*0.02,0.062*s2_c_height);
  reset_button.mousePressed(createModel);
  train_button.position(s2_c_width*0.08,0.062*s2_c_height);
  train_button.mousePressed(train);

  //CREATE ITEMS
  firstbuffer = createGraphics(s2_c_width/2,s2_c_height/3);
  secondbuffer = createGraphics(s2_c_width/2,s2_c_height/3);
  thirdbuffer = createGraphics(s2_c_width/2,s2_c_height/3);
  drawbuffer =  createGraphics(s2_c_width/2,height);

  //WE SET PARENTS
  myCanvas.parent("canvas_2");
  train_button.parent("canvas_2");
  reset_button.parent("canvas_2");
}

//draw the buffers
function drawfirstBuffer() {

    firstbuffer.background(25, 25, 25);
    weights = [3,4];

    // add label
    firstbuffer.noStroke();
    firstbuffer.fill(255,255,255);
    firstbuffer.textSize(16);
    firstbuffer.text("Neuron 1 weights",0,20);

    // we draw each of the shapes IF model es2_xists
    firstbuffer.strokeWeight(2);
    firstbuffer.noFill();
    if(s2_traincount > 1){

      //we find global max and min
      min = 10000000;
      max = -10000000;
      //loop through all weights
      for(j=0;j<weights.length;j++){
        s2_y_temp = dict[weights[j]];

        // CHECK THE max
        if(Math.max.apply(Math,s2_y_temp)>max){
          max = Math.max.apply(Math,s2_y_temp);
        }

        // CHECK THE MIN
        if(Math.min.apply(Math,s2_y_temp)<min){
          min = Math.min.apply(Math,s2_y_temp);
        }
      }

      // we loop through each weight for drawing
      firstbuffer.stroke(255,0,0);
      //firstbuffer.fill(255,0,0);
      firstbuffer.textSize(16);
      for(j=0;j<weights.length;j++){
        // we es2_xtract the values and the s2_x step
        s2_y_temp = dict[weights[j]];
        s2_x_temp = s2_y_temp.length;
        // console.log(s2_y_temp[0]);
        // we start plotting the shape
        firstbuffer.beginShape();
        for(let i =0; i < s2_x_temp;i++){
          // we map the s2_x between 0 and the length of the buffer
          s2_x = map(i,0,s2_x_temp-1,0,0.75*s2_c_width/2);
          s2_y = map(s2_y_temp[i],max,min,0.25*(s2_c_height/3),0.75*s2_c_height/3);
          s2_s2_y_unmapped = s2_y_temp[i];
          firstbuffer.vertex(s2_x,s2_y);
        }
        firstbuffer.endShape();

        if(j == 0){
          firstbuffer.noStroke();
          firstbuffer.fill(255,255,255);
          firstbuffer.text("W1 : "+ round(s2_s2_y_unmapped*100)/100,0.76*s2_c_width/2,s2_y);
          firstbuffer.noStroke();
          firstbuffer.noFill();
          //we store for equation calculation
          biases["W11"] = s2_s2_y_unmapped;
        }else{
         firstbuffer.noStroke();
         firstbuffer.fill(255,255,255);
         firstbuffer.text("B1 : "+ round(s2_s2_y_unmapped*100)/100,0.76*s2_c_width/2,s2_y);
         firstbuffer.noStroke();
         firstbuffer.noFill();
         //we store for equation calculation
         biases["B1"] = s2_s2_y_unmapped;
        }
        firstbuffer.stroke(0,255,0);
      }
    }
}

function drawsecondBuffer() {
  secondbuffer.background(50, 50, 50);
    weights = [5,6];

    // add label
    secondbuffer.noStroke();
    secondbuffer.fill(255,255,255);
    secondbuffer.textSize(16);
    secondbuffer.text("Neuron 2 weights",0,20)

    // we draw each of the shapes IF model es2_xists
    secondbuffer.strokeWeight(2);
    secondbuffer.noFill();
    if(s2_traincount > 1){

      //we find global max and min
      min = 10000000;
      max = -10000000;
      //loop through all weights
      for(j=0;j<weights.length;j++){
        s2_y_temp = dict[weights[j]];

        // CHECK THE max
        if(Math.max.apply(Math,s2_y_temp)>max){
          max = Math.max.apply(Math,s2_y_temp);
        }

        // CHECK THE MIN
        if(Math.min.apply(Math,s2_y_temp)<min){
          min = Math.min.apply(Math,s2_y_temp);
        }
      }

      // we loop through each weight
      secondbuffer.stroke(255,0,0);
      for(j=0;j<weights.length;j++){
        // we es2_xtract the values and the s2_x step
        s2_y_temp = dict[weights[j]];
        s2_x_temp = s2_y_temp.length;
        // console.log(s2_y_temp[0]);
        // we start plotting the shape
        secondbuffer.beginShape();
        for(let i =0; i < s2_x_temp;i++){
          // we map the s2_x between 0 and the length of the buffer
          s2_x = map(i,0,s2_x_temp-1,0,0.75*s2_c_width/2);
          s2_y = map(s2_y_temp[i],max,min,0.25*(s2_c_height/3),0.75*s2_c_height/3);
          s2_s2_y_unmapped = s2_y_temp[i];
          secondbuffer.vertex(s2_x,s2_y);
        }
        secondbuffer.endShape();

        if(j == 0){
          secondbuffer.noStroke();
          secondbuffer.fill(255,255,255);
          secondbuffer.text("W1 : " + round(s2_s2_y_unmapped*100)/100,0.76*s2_c_width/2,s2_y);
          secondbuffer.noStroke();
          secondbuffer.noFill();
          //we store for equation calculation
          biases["W21"] = s2_s2_y_unmapped;
        }else{
         secondbuffer.noStroke();
         secondbuffer.fill(255,255,255);
         secondbuffer.text("B1 : " + round(s2_s2_y_unmapped*100)/100,0.76*s2_c_width/2,s2_y);
         secondbuffer.noStroke();
         secondbuffer.noFill();
         //we store for equation calculation
         biases["B2"] = s2_s2_y_unmapped;
        }
        secondbuffer.stroke(0,255,0);
      }
    }
}

function drawthirdBuffer() {
  thirdbuffer.background(25, 25, 25);
    weights = [7,8,9];

    // add label
    thirdbuffer.noStroke();
    thirdbuffer.fill(255,255,255);
    thirdbuffer.textSize(16);
    thirdbuffer.text("Neuron 3 weights",0,20)

    // we draw each of the shapes IF model es2_xists
    thirdbuffer.strokeWeight(2);
    thirdbuffer.noFill();
    if(s2_traincount > 1){

      //we find global max and min
      min = 10000000;
      max = -10000000;
      //loop through all weights
      for(j=0;j<weights.length;j++){
        s2_y_temp = dict[weights[j]];

        // CHECK THE max
        if(Math.max.apply(Math,s2_y_temp)>max){
          max = Math.max.apply(Math,s2_y_temp);
        }

        // CHECK THE MIN
        if(Math.min.apply(Math,s2_y_temp)<min){
          min = Math.min.apply(Math,s2_y_temp);
        }
      }

      // we loop through each weight
      for(j=0;j<weights.length;j++){

        if(j==0){
          thirdbuffer.stroke(255,0,0);
        }else if(j==1){
          thirdbuffer.stroke(0,255,0);
        }else{
          thirdbuffer.stroke(0,0,255);
        }
        // we es2_xtract the values and the s2_x step
        s2_y_temp = dict[weights[j]];
        s2_x_temp = s2_y_temp.length;

        // we start plotting the shape
        thirdbuffer.beginShape();
        for(let i =0; i < s2_x_temp;i++){
          // we map the s2_x between 0 and the length of the buffer
          s2_x = map(i,0,s2_x_temp-1,0,0.75*s2_c_width/2);
          s2_y = map(s2_y_temp[i],max,min,0.25*(s2_c_height/3),0.75*s2_c_height/3);
          s2_s2_y_unmapped = s2_y_temp[i];
          thirdbuffer.vertex(s2_x,s2_y);
        }
        thirdbuffer.endShape();

        if(j == 0){
          thirdbuffer.noStroke();
          thirdbuffer.fill(255,255,255);
          thirdbuffer.text("W1 : "+ round(s2_s2_y_unmapped*100)/100,0.76*s2_c_width/2,s2_y);
          thirdbuffer.noStroke();
          thirdbuffer.noFill();
          //we store for equation calculation
          biases["W31"] = s2_s2_y_unmapped;
        }else if(j==1){
         thirdbuffer.noStroke();
         thirdbuffer.fill(255,255,255);
         thirdbuffer.text("W2 : " + round(s2_s2_y_unmapped*100)/100 ,0.76*s2_c_width/2,s2_y);
         thirdbuffer.noStroke();
         thirdbuffer.noFill();
         //we store for equation calculation
         biases["W32"] = s2_s2_y_unmapped;
       }else{
         thirdbuffer.noStroke();
         thirdbuffer.fill(255,255,255);
         thirdbuffer.text("B1 : "+ round(s2_s2_y_unmapped*100)/100,0.76*s2_c_width/2,s2_y);
         thirdbuffer.noStroke();
         thirdbuffer.noFill();
         //we store for equation calculation
         biases["B3"] = s2_s2_y_unmapped;
       }

      }
    }
}

function drawdrawBuffer() {
    drawbuffer.background(0, 0, 0);
    drawbuffer.noStroke();
    drawbuffer.fill(255,255,255);
    drawbuffer.textSize(16);
    drawbuffer.text("Welcome to the Neural Network Explainer",20,20);
    drawbuffer.textSize(14);
    drawbuffer.text("Please click train, or restart, and watch the network learn",20,35);
    drawbuffer.textSize(14);
    drawbuffer.text("True Equation       : Y = 1.00 X + 0.00 ",20,0.95*s2_c_height);

    //bias and weights terms for the equation
    text_bias    =  round((biases["B3"] + biases["W31"]*biases["B1"] +  biases["W32"]*biases["B2"])*100)/100;
    text_weights =  round((biases["W31"]*biases["W11"] + biases["W32"]*biases["W21"])*100)/100;
    drawbuffer.text("Network Equation : Y = " + text_weights +" X + " + text_bias,20,0.97*s2_c_height);

    //draw the target
    drawbuffer.stroke(255,255,255);
    drawbuffer.beginShape();
      for(let i =0; i < s2_x_vals.length;i++){
        // we map the s2_x between 0 and the length of the buffer
        let s2_x = map(s2_x_vals[i],0,1,0.25*s2_c_width/2,0.75*s2_c_width/2);
        let s2_y = map(s2_y_vals[i],1,0,0.9*(s2_c_height),0.1*s2_c_height);
        drawbuffer.vertex(s2_x,s2_y);
      }
    drawbuffer.endShape();

    //draw the prediction
    drawbuffer.stroke(255,0,0);
    if(s2_traincount > 1){
      drawbuffer.beginShape();
        for(let i =0; i < s2_x_c.length;i++){
          // we map the s2_x between 0 and the length of the buffer
          let s2_x = map(s2_x_c[i],0,1,0.25*s2_c_width/2,0.75*s2_c_width/2);
          let s2_y = map(s2_y_predict[i],1,0,0.9*(s2_c_height),0.1*s2_c_height);
          drawbuffer.vertex(s2_x,s2_y);
        }
      drawbuffer.endShape();
    }

}


//draw the canvas
function draw(){
  //Global background settings
  background(0);
  // Draw the buffers
  drawfirstBuffer();
  drawsecondBuffer();
  drawthirdBuffer();
  drawdrawBuffer();

  //Show the buffers
  image(drawbuffer, 0,0);
  image(firstbuffer, s2_c_width/2, 0);
  image(secondbuffer, s2_c_width/2, s2_c_height*(1/3));
  image(thirdbuffer, s2_c_width/2,s2_c_height*(2/3));
}


//create the model
function createModel(){
  s2_modelNN = tf.sequential();
  let optimizer = tf.train.sgd(0.2);
  s2_modelNN.add(tf.layers.dense({useBias : true ,activation: 'linear', units: 2,kernelInitializer: 'VarianceScaling', inputShape: [1]}));
  s2_modelNN.add(tf.layers.dense({useBias : true ,activation: 'linear', units: 1,kernelInitializer: 'VarianceScaling'}));
  s2_modelNN.compile({loss: 'meanSquaredError', optimizer: optimizer });

  s2_xs      = tf.tensor2d(s2_x_vals,[s2_x_vals.length,1]);
  s2_ys      = tf.tensor2d(s2_y_vals,[s2_y_vals.length,1]);
  s2_x_curve = tf.tensor2d(s2_x_c,[s2_x_c.length,1]);

  train();
}

//s2_train the model
function train(){
s2_trained = true;
s2_traincount = s2_traincount +1;
let i = 0
let s2_hist = s2_modelNN.fit(s2_xs, s2_ys, {epochs: 1 ,  callbacks: {
  onEpochEnd: () => {
  i = i + 1 ;
  //we store the raw weights in a dictionars2_y
  dict[3].push(s2_modelNN.layers[0].getWeights()[0].dataSync()[0]);
  dict[4].push(s2_modelNN.layers[0].getWeights()[1].dataSync()[0]);
  dict[5].push(s2_modelNN.layers[0].getWeights()[0].dataSync()[1]);
  dict[6].push(s2_modelNN.layers[0].getWeights()[1].dataSync()[1]);
  dict[7].push(s2_modelNN.layers[1].getWeights()[0].dataSync()[0]);
  dict[8].push(s2_modelNN.layers[1].getWeights()[0].dataSync()[1]);
  dict[9].push(s2_modelNN.layers[1].getWeights()[1].dataSync()[0]);

  //we predict
  s2_y_predict= s2_modelNN.predict(s2_x_curve);
  s2_y_predict =s2_y_predict.dataSync();

}}});
console.log("trained model")
}
