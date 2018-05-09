function BackgroundLines (canvas) {
	var self = this;
	this.x = Array();
	this.y = Array();
	this.rate = Array();
	this.rateFunction = function() {
		return this.getBiasedInt(0, 100, 25, 1) * this.width / 1920 * 0.5;
	};
	this.alpha = Array();
	this.alphaFunction = function() {
		return this.getBiasedInt(10, 90, 50, 1) * 0.01;
	};
	this.length = Array();
	this.lengthFunction = function() {
		return this.getRandomInt(this.height / 5, this.height);
	};
	this.terminate = false;
	this.width = canvas.width;
	this.height = canvas.height;
	this.lines = 30;
	this.ms = Array(); // minimum speed of falling
	
	// set up lines
	this.initialize = function () {
		for (var i = 0; i < this.lines; i++) {
			this.x[i] = (this.width / this.lines) * (i + self.getRandomInt(0, 100) * 0.01);
			this.y[i] = 0 + self.getRandomInt(this.height * -1, 0);
			this.rate[i] = self.rateFunction();
			this.alpha[i] = self.alphaFunction();			
			this.length[i] = self.lengthFunction();
			this.ms[i] = self.getRandomInt(2,10);
		};
		return;
	};
	
	// begin animation
	this.begin = function () {
		this.draw(this.x,this.y,this.rate,this.alpha,this.length,this.ms);
		return;
	};
	
	// get random integer
	this.getRandomInt = function (min, max) {
  	return Math.floor(Math.random() * (max - min + 1)) + min;
	};

	// get biased integer
	this.getBiasedInt = function (min, max, bias, influence) {
		var rnd = Math.random() * (max - min) + min;
		var mix = Math.random() * influence;
		return rnd * (1 - mix) + bias * mix;
	};

	// the main animation loop
	this.draw = function (x,y,r,a,l,ms) {
		var c = canvas;
		var ctx = c.getContext('2d');
		
		ctx.clearRect(0, 0, this.width, this.height);
		for (var i = 0; i < this.lines; i++) {
			ctx.beginPath();
			var grd = ctx.createLinearGradient(x[i],y[i] - l[i],x[i],y[i]);
			grd.addColorStop(1, "rgba(255,255,255,"+a[i]+")");
			grd.addColorStop(0, "rgba(255,255,255,0)");
			ctx.strokeStyle=grd;
			if (y[i] <= this.height ) {
				ctx.moveTo(x[i],y[i] - l[i]);
				ctx.lineTo(x[i], y[i]);
				ctx.stroke();
				if (r[i] > ms[i] && y[i] > 0) {
					r[i] = r[i] * 0.975; // if on screen and above min speed: deccelerate
				}
			}
			if (y[i] > this.height ) {
				ctx.moveTo(x[i], y[i] - l[i]);
				ctx.lineTo(x[i], this.height);
				ctx.stroke();
				r[i] = r[i] * 1.02; // if off screen, accelerate
			}
    		y[i] = y[i] + r[i];
			if (y[i] > this.height + l[i]) {
				y[i] = 0;
				x[i] = (this.width / this.lines) * (i + self.getRandomInt(0, 100) * 0.01);
				r[i] = self.rateFunction();
				a[i] = self.alphaFunction();
				l[i] = self.lengthFunction();
				ms[i] = self.getRandomInt(2,5);
				// console.log([x[i],r[i],a[i],l[i]]);
			}
		}
		if (this.terminate) {
			return;
		}
		var loopTimer = setTimeout(function() {self.draw(x,y,r,a,l,ms);}, 50);
	};

}

function setupBackground () {
	var canvas = document.getElementById('canvas');
	canvas.width = screen.width;
	canvas.height = screen.height;
	var background = new BackgroundLines(canvas);
	window.onload = function () {
		background.initialize();
		background.begin();
	};
};

setupBackground();
