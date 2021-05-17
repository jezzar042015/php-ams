function CommaFormatted(amount,decimalspoints) {

    // return empty string if not a number
    if(isNaN(amount)) { 
        return ''; 
    }

    //round number
    var amountVal = parseFloat(amount);
    
    switch (decimalspoints) {
        case 0:
            amountVal = Math.round(amountVal);
            break;
        case 2:
            amountVal = Math.round(amountVal * 100) / 100;
            break;
    }

    amount = amountVal.toString();

	var delimiter = ","; // replace comma if desired
	var a = amount.split('.',2)
	var d = a[1];
	var i = parseInt(a[0]);
	
    // if number is below zero then prepare minus sign
    var minus = '';
	if(i < 0) { 
        minus = '-'; 
    }
	

    i = Math.abs(i);
	var n = new String(i);
	var a = [];
	while(n.length > 3) {
		var nn = n.substr(n.length-3);
		a.unshift(nn);
		n = n.substr(0,n.length-3);
	}

	if(n.length > 0) { 
        a.unshift(n); 
    }

	n = a.join(delimiter);
	
    if (d == undefined) {
        d = '00';
    }

    if (decimalspoints == 0) {
        amount = n;
        return amount;
    }

    if(d.length < 1) { 
        amount = n; 
    } else if (d.length == 1) {
        amount = n + '.' + d + '0';
    } else { 
        amount = n + '.' + d; 
    }

	amount = minus + amount;
	return amount;
}