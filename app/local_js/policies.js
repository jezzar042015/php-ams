

// policy form controls
const coveragetype = document.getElementById("fm-policy-coveragetype");
const effective = document.getElementById("fm-policy-effective");
const expiration = document.getElementById("fm-policy-expiration");
const isGrossReceipts = document.getElementById("isGrossReceipts");
const isGrossReceipts_lbl = document.getElementById("isGrossReceipts-label");
const baseperunit = document.getElementById("fm-policy-baseperunit");
const baseperunit_lbl = document.getElementById("fm-policy-baseperunit-label");
const premium = document.getElementById("fm-policy-premium");
const premium_lbl = document.getElementById("fm-policy-premium-label");
const pdrate = document.getElementById("fm-policy-pdrate");
const pdrate_lbl = document.getElementById("fm-policy-pdrate-label");

function initiate_newpolicyform () {
    coveragetype.value = 0;
    isGrossReceipts.style.display = "none";
    isGrossReceipts_lbl.style.display = "none";
    effective.value = null;
    expiration.value = null;
}

// effective onchange event
effective.addEventListener('change', function () {
    
    var effDate = new Date(this.value);

    if (isValidDate(effDate)) {
        let d = effDate.getDate() + 1;
        let m = effDate.getMonth();
        let y = effDate.getFullYear() + 1;

        // console.log(m + '/' + d + '/' + y);

        let expire = new Date(y,m,d);
        expiration.value = expire.toISOString().substring(0,10);
    }
    
});

// coveragetype onchange event
coveragetype.addEventListener('change', function () {

    switch (this.value) {
        case '1':
        case '2':

            isGrossReceipts.style.display = "inline-block";
            isGrossReceipts_lbl.style.display = "inline-block";
            pdrate.style.display = "none";
            pdrate_lbl.style.display = "none";

            if (isGrossReceipts.checked) {
                baseperunit.style.display = "none";
                baseperunit_lbl.style.display = "none";
                premium.style.display = "inline-block";
                premium_lbl.style.display = "inline-block";
            } 
            else {
                baseperunit.style.display = "inline-block";
                baseperunit_lbl.style.display = "inline-block";
                premium.style.display = "none";
                premium_lbl.style.display = "none";
            }


            break;
        case '3':
            isGrossReceipts.style.display = "inline-block";
            isGrossReceipts_lbl.style.display = "inline-block";
            baseperunit.style.display = "none";
            baseperunit_lbl.style.display = "none";

            if (isGrossReceipts.checked) {
                pdrate.style.display = "none";
                pdrate_lbl.style.display = "none";
                premium.style.display = "inline-block";
                premium_lbl.style.display = "inline-block";
            } 
            else {
                pdrate.style.display = "inline-block";
                pdrate_lbl.style.display = "inline-block";
                premium.style.display = "none";
                premium_lbl.style.display = "none";
            }
            break;
        case '4':            
        case '5':
        case '6':
            isGrossReceipts.style.display = "none";
            isGrossReceipts_lbl.style.display = "none";
            baseperunit.style.display = "none";
            baseperunit_lbl.style.display = "none";
            pdrate.style.display = "none";
            pdrate_lbl.style.display = "none";
            premium.style.display = "inline-block";
            premium_lbl.style.display = "inline-block";
        
            break;

    }
});

function isValidDate(d) {
    return d instanceof Date && !isNaN(d);
}