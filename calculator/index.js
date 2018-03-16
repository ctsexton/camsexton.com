var prevClick = 'op';
var operators = {
	Div: '/',
	X: '*',
	Sub: '-',
	Add: '+'
}

var digits = [0,1,2,3,4,5,6,7,8,9];

calculatorData = {
	currentFloat: 0,
	currentFloatArray: [],
	buildCurrentFloat: function (digit) {
		this.currentFloatArray.push(digit);
		this.setCurrentFloat(this.currentFloatArray.join(''));
	},
	setCurrentFloat: function (number) {
		this.currentFloat = number;
		this.currentFloatArray = [number];
		document.getElementById('disp').innerHTML = this.currentFloat;
	},
	sequence: [],
	insertCurrentFloat: function () {
		this.sequence.push(this.currentFloat);
	},
	insertOp: function (operator) {
		this.sequence.push(operator)
	},
	evaluate: function () {
		var calcString = this.sequence.join('');
		var answer = Math.round(eval(calcString) * Math.pow(10, 4)) / Math.pow(10, 4);;
		this.setCurrentFloat(answer);
		this.sequence = [answer];
	},
	clearSeq: function () {
		this.sequence = [];
	}
}

function setPrevClick(button) {
	prevClick = button;
};

for (i in digits) {
	var closureMaker = function(num) {
		return function(event) {
			if (prevClick === 'op') {
				calculatorData.setCurrentFloat(num);
			} else {
				calculatorData.buildCurrentFloat(num);
			};
			setPrevClick(num);
		};
	};
	var closure = closureMaker(i);

	document.getElementById('button' + i).addEventListener("click", closure);
};

for (item in operators) {

	var closureMaker = function(op) {
		return function (event) {
			calculatorData.insertCurrentFloat();
			calculatorData.evaluate();
			calculatorData.insertOp(op);
			setPrevClick('op');
		};
	};
	var closure = closureMaker(operators[item]);

		document.getElementById('button' + item).addEventListener("click", closure);
};

document.getElementById('enter').addEventListener("click",
	function() {
		calculatorData.insertCurrentFloat();
		calculatorData.evaluate();
		calculatorData.clearSeq();
		setPrevClick('op');
	});

document.getElementById('buttonC').addEventListener("click",
	function() {
		calculatorData.clearSeq();
		calculatorData.setCurrentFloat(0);
		setPrevClick('op');
	});

document.getElementById('buttonDot').addEventListener("click",
	function() {
		calculatorData.buildCurrentFloat('.');
		setPrevClick('.');
	});
