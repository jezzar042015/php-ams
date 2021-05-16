
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
        '</tr>';

        xhr.open('GET','http://localhost/php-ams/api/vehicles/read.php?accountid=' + accountid ,true);


        xhr.onload = function () {

            if (this.status == 200) {
                vehicles = JSON.parse(xhr.responseText);
                
                

                // display contacts
                for (let i = 0; i < vehicles.count; i++) {
                    
                    var veh_year =  
                        (vehicles.vehicles[i].vehicle_year == null) ? '' : vehicles.vehicles[i].vehicle_year;
                    var veh_make = (vehicles.vehicles[i].makeid == 14) ? 'Unidentified' : '';

                    var veh_vin = (vehicles.vehicles[i].vin == null) ? '' : vehicles.vehicles[i].vin;

                    var veh_unit = (vehicles.vehicles[i].unit_number == null) ? '' : vehicles.vehicles[i].unit_number;
                    var veh_type = (vehicles.vehicles[i].typeid == null) ? '' : vehicles.vehicles[i].typeid;
                    var veh_value = (vehicles.vehicles[i].pdvalue == null) ? '' : vehicles.vehicles[i].pdvalue;
                    var veh_driver = (vehicles.vehicles[i].driverid == null) ? '' : vehicles.vehicles[i].driverid;

                    // veh_year = '';
                    // veh_make = '';
                    // veh_vin = '';
                    // veh_unit = '';
                    // veh_type = '';
                    // veh_value = '';
                    // veh_driver = '';

                    vehiclesList += 
                        '<tr>' + 
                            '<td>' + veh_year + '</td>' +
                            '<td>' + veh_make + '</td>' +
                            '<td>' + veh_vin + '</td>' +
                            '<td>' + veh_unit + '</td>' +
                            '<td>' + veh_type + '</td>' +
                            '<td>' + veh_value + '</td>' +
                            '<td>' + veh_driver + '</td>' +
                        '</tr>';
                }

                
            }

            document.getElementById('vehicles-list-table').innerHTML = vehiclesList;
        }

        xhr.send();   
  
}