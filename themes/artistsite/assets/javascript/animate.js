function AnimateBG (canvas) {
	self = this;
	this.terminate = false;
	var canvasWidth = canvas.width;
	var canvasHeight = canvas.height;
	var columns = 30;

	var Droplet = function(index, columns, width, height) {
		this.index = index;
		this.columns = columns;
		this.x = (width / columns) * (index + getRandomInt(0, 100) * 0.01);
		this.y = getRandomInt(height * -1, 0);
		this.rate = getBiasedInt(0, 100, 25, 1) * width / 1920 * 0.5;
		this.opacity = getBiasedInt(10, 90, 50, 1) * 0.01;
		this.length = getRandomInt(height / 5, height);
		this.minSpeed = getRandomInt(2,10);
	}

	var rain = Array();
	this.init = function() {
		for (var index = 0; index < columns; index++) {
			rain.push(new Droplet(index, columns, canvasWidth, canvasHeight));
		}
	}

	this.draw = function() {
		var ctx = canvas.getContext('2d');

		ctx.clearRect(0, 0, canvasWidth, canvasHeight);

		rain = rain.map(function(drop) {
			var x = drop.x;
			var y = drop.y;
			var length = drop.length;
			var rate = drop.rate;
			var minSpeed = drop.minSpeed;
			var opacity = drop.opacity;

			ctx.beginPath();
			var grd = ctx.createLinearGradient(x, y - length, x, y);
			grd.addColorStop(1, "rgba(255,255,255,"+opacity+")");
			grd.addColorStop(0, "rgba(255,255,255,0)");
			ctx.strokeStyle=grd;

			// if drop end onscreen and above minSpeed, gradually deccelerate
			if (y <= canvasHeight) {
				ctx.moveTo(x, y - length);
				ctx.lineTo(x, y);
				ctx.stroke();
				if (rate > minSpeed && y > 0) {
					drop.rate = rate * 0.975;
				}
			}

			// if drop end offscreen, accelerate
			if (y > canvasHeight) {
				ctx.moveTo(x, y - length);
				ctx.lineTo(x, canvasHeight);
				ctx.stroke();
				drop.rate = rate * 1.02;
			}

			// increment Y position by rate
			drop.y = y + rate;

			if (y > canvasHeight + length) {
				return new Droplet(drop.index, drop.columns, canvasWidth, canvasHeight);
			}
			return drop;
		});
		if (self.terminate) {
			return;
		}

		setTimeout(self.draw, 50);
	}

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
}

function setupCanvas () {
	var canvas = document.getElementById('canvas');
	canvas.width = screen.width;
	canvas.height = screen.height;
	var background = new AnimateBG(canvas);
	window.onload = function () {
		background.init();
		background.draw();
	};
}

setupCanvas();
