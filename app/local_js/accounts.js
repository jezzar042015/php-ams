
var accData;


window.addEventListener('load', function () {

    if (document.readyState === 'complete') {
    
        // perform ajax by getting the whole list of accounts
        var xhr = new XMLHttpRequest();
    
        xhr.open('GET','http://localhost/php-ams/api/accounts/read.php',true);
    
        xhr.onload = function () {
            if (this.status == 200) {
                accData = JSON.parse(xhr.responseText);
                
                loadAccountsList(accData.accounts);
                loadAccountSelect(accData.accounts[0].accountid);
            }
        }

        xhr.send();
    
    }
})


function loadAccountsList(accountsToLoad) {
    var acclist = '';

    for(let i = 0; i<accountsToLoad.length; i++) {
        acclist += 
            '<li onclick="loadAccountSelect('+ accountsToLoad[i].accountid 
            + ')" id="' + accountsToLoad[i].accountid +'">' 
            + accountsToLoad[i].legalname + '</li>';
    }    

    acclist = '<ul>'+ acclist +'</ul>';
    document.getElementById('accounts-options').innerHTML = acclist;
}

function loadAccountSelect(accountID) {
    
    // document.getElementById(accountID).classList.add("selectedAccount");
    var account = accData.accounts.filter(function(acc){
        return acc.accountid == accountID;
    })

    var acc = account[0];

    document.getElementById('legalname').innerText = acc.legalname;
    document.getElementById('usdot').innerText = acc.usdot;
    document.getElementById('authority').innerText = null;
    document.getElementById('statePermit').innerText = acc.statePermit;
    document.getElementById('taxid').innerText = acc.taxid;
    document.getElementById('source_name').innerText = acc.source_name;
    document.getElementById('agent_name').innerText = acc.agent_name;
    document.getElementById('dba').innerText = acc.dba;
    document.getElementById('radius_name').innerText = acc.radius_name;
    document.getElementById('operation_name').innerText = acc.operation_name;
    document.getElementById('accountType_name').innerText = acc.accountType_name;
    document.getElementById('mailing').innerText =  
        acc.mailAddress + ', ' + acc.mailCity_name + ', ' + acc.mailState + ' ' + acc.mailZip;
    document.getElementById('garaging').innerText =  
        acc.garageAddress + ', ' + acc.garageCity_name + ', ' + acc.garageState + ' ' + acc.garageZip;
}

