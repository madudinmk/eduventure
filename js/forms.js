
function verify_acco() {
			//var x = document.forms[0];
			var x = document.forms["acco-pg-form"];
			var inputNum = x.elements;
			//var val = [];
			var i, num;
			var sum = 0;
			var max = 0;
			for (i = 0; i < inputNum.length; i++) {
			  if (inputNum[i].nodeName === "INPUT" && inputNum[i].type === "number") {
			    num = Number(inputNum[i].value);
			    //val.push(num);
			    sum += num;
			    if(max < inputNum[i].max) {
			    	max = inputNum[i].max;
			    }
			  }
			}

			if(sum != max) {
				alert("You must choose accommodation accordingly!");
				return false;
			} else {
				return true;
			}
		}

function check_acco() {
			var x = document.forms["acco-pg-form"];
			var inputNum = x.elements;
			var i, num;
			var sum = 0;
			var max = 0;
			for (i = 0; i < inputNum.length; i++) {
			  if (inputNum[i].nodeName === "INPUT" && inputNum[i].type === "number") {
			    num = Number(inputNum[i].value);
			    sum += num;
			    if(max < inputNum[i].max) {
			    	max = inputNum[i].max;
			    }
			  }
			}
		  document.getElementById("demo1").innerHTML = "sum: " + sum;
		  document.getElementById("demo2").innerHTML = "max: " + max;
		}