
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
            + ')" id="' + accountsToLoad[i].accountid +'" class="accounts-option-list">' 
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

    // console.log(acc);

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
    document.getElementById('notes').value = acc.notes;  


    // load contacts
    loadAccountContacts (accountID);
    loadAccountDrivers (accountID);
    loadAccountVehicles (accountID);
    loadAccountPolicies (accountID);
}

document.getElementById("account-search").addEventListener('keyup', function() {
    var keyword =  document.getElementById("account-search").value;

    filterAccountsList(keyword.toLowerCase());
});


function filterAccountsList(keyword) {
    var listColl = document.getElementsByClassName("accounts-option-list");

    for ( let i = 0; i < listColl.length ; i++) {
        
        var listContent =  listColl[i].textContent;

        if (listContent.toLowerCase().indexOf(keyword) > -1) {
            listColl[i].style.display = "";
        } else {
            listColl[i].style.display = "none";
        }
    }
    

}

function loadAccountContacts(accountid) {
    var xhr = new XMLHttpRequest();
    var contacts;
    var contactsList = 
        '<tr>' +
            '<th class="contacts-col-name">Name</th>' +
            '<th class="contacts-col-title">Title</th>' +
            '<th class="contacts-col-mobile">Mobile</th>' +
            '<th class="contacts-col-email">Email</th>' +
            '<th class="contacts-col-actions"></th>' +
        '</tr>';

    xhr.open('GET','http://localhost/php-ams/api/contacts/read.php?accountid=' + accountid ,true);

    xhr.onload = function () {
        if (this.status == 200) {
            contacts = JSON.parse(xhr.responseText);
            
            
            // display contacts
            for (let i = 0; i < contacts.count; i++) {
                contactsList += 
                '<tr>' +                            
                    '<td>' + contacts.contacts[i].firstname + ' ' 
                        + contacts.contacts[i].lastname + '</td>' +
                    '<td>' + contacts.contacts[i].title + '</td>' +
                    '<td>' + contacts.contacts[i].business_phone + '</td>' +
                    '<td>' + contacts.contacts[i].email1.toLowerCase() + '</td>' +
                    '<td></td>' +
                '</tr>'
            }
            
            document.getElementById('contacts-list-table').innerHTML = contactsList;
        }
    }

    xhr.send();    

    
}

function loadAccountDrivers (accountid) {
    var xhr = new XMLHttpRequest();
    var drivers;
    var driversList = 
        '<tr>' +
            '<th class="drivers-col-name">Name</th>' +
            '<th class="drivers-col-state">State</th>' +
            '<th class="drivers-col-cdlnumber">CDL No</th>' +
            '<th class="drivers-col-year">Year</th>' +
            '<th class="drivers-col-hired">Hired</th>' +
            '<th class="drivers-col-terminated">Terminated</th>' +
            '<th class="drivers-col-actions"></th>' +
        '</tr>';   

    xhr.open('GET','http://localhost/php-ams/api/drivers/read.php?accountid=' + accountid ,true);

    xhr.onload = function () {
        if (this.status == 200) {
            drivers = JSON.parse(xhr.responseText);
            
            // display contacts
            for (let i = 0; i < drivers.count; i++) {

                var drivername = drivers.drivers[i].firstname 
                                    + ' ' + drivers.drivers[i].lastname;
                var driver_state = drivers.drivers[i].cdl_state;
                var driver_license = drivers.drivers[i].cdl_number;
                var license_year = (drivers.drivers[i].year_licensed == null) ? '' : drivers.drivers[i].year_licensed;
                var hired = (drivers.drivers[i].hiredate == null) ? '' : drivers.drivers[i].hiredate;
                var terminated = (drivers.drivers[i].terminationdate == null) ? '' : drivers.drivers[i].terminationdate;

                driversList += 
                    '<tr>' +
                        '<td>' + drivername + '</td>' +
                        '<td>' + driver_state + '</td>' +
                        '<td>' + driver_license + '</td>' +
                        '<td>' + license_year + '</td>' +
                        '<td>' + hired + '</td>' +
                        '<td>' + terminated + '</td>' +
                        '<td></td>' +
                    '</tr>';

            }
            
            document.getElementById('drivers-list-table').innerHTML = driversList;
        }
    }

    xhr.send();   

}

function loadAccountVehicles (accountid) {
    var xhr = new XMLHttpRequest();
    var vehicles;
    var vehiclesList = 
        '<tr>' +
            '<th class="vehicles-col-year">Year</th>' +
            '<th class="vehicles-col-make">Make</th>' +
            '<th class="vehicles-col-vin">VIN</th>' +
            '<th class="vehicles-col-unit">Unit</th>' +
            '<th class="vehicles-col-type">Type</th>' +
            '<th class="vehicles-col-value">Value</th>' +
            '<th class="vehicles-col-driver">Driver</th>' +
            '<th class="vehicles-col-actions"></th>' +
        '</tr>';

        xhr.open('GET','http://localhost/php-ams/api/vehicles/read.php?accountid=' + accountid ,true);


        xhr.onload = function () {

            if (this.status == 200) {
                vehicles = JSON.parse(xhr.responseText);
                
                

                // display contacts
                for (let i = 0; i < vehicles.count; i++) {
                    
                    var veh_year =  
                        (vehicles.vehicles[i].vehicle_year == null) ? '' : vehicles.vehicles[i].vehicle_year;
                    var veh_make = 
                        (vehicles.vehicles[i].makename == null) ? '' : vehicles.vehicles[i].makename;

                    var veh_vin = (vehicles.vehicles[i].vin == null) ? '' : vehicles.vehicles[i].vin;

                    var veh_unit = (vehicles.vehicles[i].unit_number == null) ? '' : vehicles.vehicles[i].unit_number;
                    var veh_type = (vehicles.vehicles[i].typename == null) ? '' : vehicles.vehicles[i].typename;
                    var veh_value = (vehicles.vehicles[i].pdvalue == null) ? '' : CommaFormatted(vehicles.vehicles[i].pdvalue,0);
                    var veh_driver = (vehicles.vehicles[i].drivername == null) ? '' : vehicles.vehicles[i].drivername;

                    vehiclesList += 
                        '<tr>' + 
                            '<td class="vehicles-col-year">' + veh_year + '</td>' +
                            '<td class="vehicles-col-make">' + veh_make + '</td>' +
                            '<td class="vehicles-col-vin">' + veh_vin + '</td>' +
                            '<td class="vehicles-col-unit">' + veh_unit + '</td>' +
                            '<td class="vehicles-col-type">' + veh_type + '</td>' +
                            '<td class="vehicles-col-value">' + veh_value + '</td>' +
                            '<td class="vehicles-col-driver">' + veh_driver + '</td>' +
                            '<td class="vehicles-col-actions"></td>' +
                        '</tr>';
                }

                
            }

            document.getElementById('vehicles-list-table').innerHTML = vehiclesList;
        }

        xhr.send();   
  
}

function loadAccountPolicies (accountid) {
    var xhr = new XMLHttpRequest();
    var policies;
    var policiesList = 
        '<tr>' +
        '<th class="policies-col-type">Coverage Type</th> ' +
        '<th class="policies-col-effective">Effective</th> ' +
        '<th class="policies-col-expiration">Expiration</th> ' +
        '<th class="policies-col-carrier">Carrier</th> ' +
        '<th class="policies-col-mga">MGA</th> ' +
        '<th class="policies-col-policyno">Policy Number</th> ' +
        '<th class="policies-col-prem_initial">Initial Premium</th> ' +
        '<th class="policies-col-prem_current">Current Premium</th> ' +
        '<th class="policies-col-actions"></th> ' +
        '</tr>';
        
    xhr.open('GET','http://localhost/php-ams/api/policies/read.php?accountid=' + accountid ,true);

    xhr.onload = function () {

        if (this.status == 200) {
            policies = JSON.parse(xhr.responseText);
            
            for (let i = 0; i < policies.policies.length; i++) {
                
                var coverage_type = (policies.policies[i].coveragetype_name == null) ? '' : policies.policies[i].coveragetype_name;  
                var effective = (policies.policies[i].effective == null) ? '' : policies.policies[i].effective;  
                var expiration = (policies.policies[i].expiration == null) ? '' : policies.policies[i].expiration;
                var carrier = (policies.policies[i].carriername == null) ? '' : policies.policies[i].carriername;
                var mga = (policies.policies[i].mganame == null) ? '' : policies.policies[i].mganame;
                var policyno = (policies.policies[i].policyNumber == null) ? '' : policies.policies[i].policyNumber;
                var prem_initial = (policies.policies[i].initial_premium == null) ? '' : policies.policies[i].initial_premium;
                var prem_current = (policies.policies[i].cummulative_premium == null) ? '' : policies.policies[i].cummulative_premium;

                

                policiesList += 
                    '<tr>' +
                    '<td class="policies-col-type">' + coverage_type +'</td>' +
                    '<td class="policies-col-effective">' + effective +'</td>' +
                    '<td class="policies-col-expiration">' + expiration +'</td>' +
                    '<td class="policies-col-carrier">' + carrier +'</td>' +
                    '<td class="policies-col-mga">' + mga +'</td>' +
                    '<td class="policies-col-policyno">' + policyno +'</td>' +
                    '<td class="policies-col-prem_initial">' + CommaFormatted(prem_initial,2) +'</td>' +
                    '<td class="policies-col-prem_current">' + CommaFormatted(prem_current,2) +'</td>' +
                    '<td class="policies-col-actions"></td>' +
                    '</tr>';
            }
        }

        document.getElementById('policies-list-table').innerHTML = policiesList;
    }

    xhr.send();   
}