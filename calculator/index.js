var prevClick = 'op';
var operators = {
	Div: '/',
	X: '*',
	Sub: '-',
	Add: '+'
}

var digits = [0,1,2,3,4,5,6,7,8,9];

var calculatorData = {
	currentFloat: 0,
	currentFloatArray: [],
	// called as user types in number to screen
	buildCurrentFloat: function (digit) {
		// Prevent more than a single decimal point occurring in array
		if (this.currentFloatArray.includes('.') && digit === '.') {
			return;
		} else {
			this.currentFloatArray.push(digit);
			console.log(this.currentFloatArray);
			this.setCurrentFloat(this.currentFloatArray.join(''));
		}
	},
	// sets the current number and displays it on page
	setCurrentFloat: function (number) {
		this.currentFloat = number;
		this.currentFloatArray = number.toString().split("");
		document.getElementById('disp').innerHTML = this.currentFloat;
	},
	// the sequence is the specific set of mathematical operations and numbers typed in by the user, which is evaluated later
	sequence: [],
	// place the next number into the sequence
	insertCurrentFloat: function () {
		this.sequence.push(this.currentFloat);
	},
	// place an operator (+, -, *, /) into the sequence
	insertOp: function (operator) {
		this.sequence.push(operator)
	},
	//evaluate the sequence, round answer and display on page. Reset sequence to begin with current answer.
	evaluate: function () {
		var calcString = this.sequence.join('');
		var answer = Math.round(eval(calcString) * Math.pow(10, 4)) / Math.pow(10, 4);;
		this.setCurrentFloat(answer);
		this.sequence = [answer];
	},
	// clear the sequence (when user clears it)
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
