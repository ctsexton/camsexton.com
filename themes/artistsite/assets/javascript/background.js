function BackgroundLines (canvas) {
	var self = this;
	var x = Array();
	var y = Array();
	var rate = Array();
	var rateFunction = function() {
		return getBiasedInt(0, 100, 25, 1) * width / 1920 * 0.5;
	};
	var alpha = Array();
	var alphaFunction = function() {
		return getBiasedInt(10, 90, 50, 1) * 0.01;
	};
	var length = Array();
	var lengthFunction = function() {
		return getRandomInt(height / 5, height);
	};
	var terminate = false;
	var width = canvas.width;
	var height = canvas.height;
	var lines = 30;
	var ms = Array(); // minimum speed of falling
	
	// set up lines
	this.initialize = function () {
		for (var i = 0; i < lines; i++) {
			x[i] = (width / lines) * (i + getRandomInt(0, 100) * 0.01);
			y[i] = 0 + getRandomInt(height * -1, 0);
			rate[i] = rateFunction();
			alpha[i] = alphaFunction();			
			length[i] = lengthFunction();
			ms[i] = getRandomInt(2,10);
		};
		return;
	};
	
	// begin animation
	this.begin = function () {
		this.draw(x,y,rate,alpha,length,ms);
		return;
	};
	
	// get random integer
	var getRandomInt = function (min, max) {
  	return Math.floor(Math.random() * (max - min + 1)) + min;
	};

	// get biased integer
	var getBiasedInt = function (min, max, bias, influence) {
		var rnd = Math.random() * (max - min) + min;
		var mix = Math.random() * influence;
		return rnd * (1 - mix) + bias * mix;
	};

	// the main animation loop
	this.draw = function (x,y,r,a,l,ms) {
		var c = canvas;
		var ctx = c.getContext('2d');
		
		ctx.clearRect(0, 0, width, height);
		for (var i = 0; i < lines; i++) {
			ctx.beginPath();
			var grd = ctx.createLinearGradient(x[i],y[i] - l[i],x[i],y[i]);
			grd.addColorStop(1, "rgba(255,255,255,"+a[i]+")");
			grd.addColorStop(0, "rgba(255,255,255,0)");
			ctx.strokeStyle=grd;
			if (y[i] <= height ) {
				ctx.moveTo(x[i],y[i] - l[i]);
				ctx.lineTo(x[i], y[i]);
				ctx.stroke();
				if (r[i] > ms[i] && y[i] > 0) {
					r[i] = r[i] * 0.975; // if on screen and above min speed: deccelerate
				}
			}
			if (y[i] > height ) {
				ctx.moveTo(x[i], y[i] - l[i]);
				ctx.lineTo(x[i], height);
				ctx.stroke();
				r[i] = r[i] * 1.02; // if off screen, accelerate
			}
    		y[i] = y[i] + r[i];
			if (y[i] > height + l[i]) {
				y[i] = 0;
				x[i] = (width / lines) * (i + getRandomInt(0, 100) * 0.01);
				r[i] = rateFunction();
				a[i] = alphaFunction();
				l[i] = lengthFunction();
				ms[i] = getRandomInt(2,5);
				// console.log([x[i],r[i],a[i],l[i]]);
			}
		}
		if (terminate) {
			return;
		}
		var loopTimer = setTimeout(function() {self.draw(x,y,r,a,l,ms);}, 50);
	};

}

function setupBackground () {
	var canvas = document.getElementById('canvas');
	canvas.width = document.width;
	canvas.height = document.height;
	var background = new BackgroundLines(canvas);
	window.onload = function () {
		background.initialize();
		background.begin();
	};
};

setupBackground();
