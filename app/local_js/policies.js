

// policy form controls
const coveragetype = document.getElementById("fm-policy-coveragetype");
const effective = document.getElementById("fm-policy-effective");
const expiration = document.getElementById("fm-policy-expiration");
const isGrossReceipts = document.getElementById("isGrossReceipts");
const isGrossReceipts_lbl = document.getElementById("isGrossReceipts-label");
const baseperunit = document.getElementById("fm-policy-baseperunit");
const baseperunit_lbl = document.getElementById("fm-policy-baseperunit-label");
const pdrate = document.getElementById("fm-policy-pdrate");
const pdrate_lbl = document.getElementById("fm-policy-pdrate-label");
const trailerrate = document.getElementById("fm-policy-trailerrate");
const trailerrate_lbl = document.getElementById("fm-policy-trailerrate-label");
const duesperunit = document.getElementById("fm-policy-duesperunit");
const duesperunit_lbl = document.getElementById("fm-policy-duesperunit-label");
const bfrate = document.getElementById("fm-policy-bfrate");
const bfrate_lbl = document.getElementById("fm-policy-bfrate-label");
const brokerfee = document.getElementById("fm-policy-brokerfee");
const brokerfee_lbl = document.getElementById("fm-policy-brokerfee-label");
const notrate = document.getElementById("fm-policy-notrate");
const notrate_lbl = document.getElementById("fm-policy-notrate-label");
const tirate = document.getElementById("fm-policy-tirate");
const tirate_lbl = document.getElementById("fm-policy-tirate-label");

const premium = document.getElementById("fm-policy-premium");
const premium_lbl = document.getElementById("fm-policy-premium-label");
const strate = document.getElementById("fm-policy-strate");
const strate_lbl = document.getElementById("fm-policy-strate-label");

const commrate = document.getElementById("fm-policy-commrate");
const commrate_lbl = document.getElementById("fm-policy-commrate-label");
const commission = document.getElementById("fm-policy-commission");
const commission_lbl = document.getElementById("fm-policy-commission-label");
const surcharge = document.getElementById("fm-policy-surcharge");
const surcharge_lbl = document.getElementById("fm-policy-surcharge-label");
const surplustax = document.getElementById("fm-policy-surplustax");
const surplustax_lbl = document.getElementById("fm-policy-surplustax-label");

const policyfees = document.getElementById("fm-policy-policyfees");
const policyfees_lbl = document.getElementById("fm-policy-policyfees-label");
const mgafees = document.getElementById("fm-policy-mgafees");
const mgafees_lbl = document.getElementById("fm-policy-mgafees-label");
const otherfees = document.getElementById("fm-policy-otherfees");
const otherfees_lbl = document.getElementById("fm-policy-otherfees-label");
const total = document.getElementById("fm-policy-total");
const total_lbl = document.getElementById("fm-policy-total-label");

const carrier = document.getElementById("fm-policy-carrier");
const mga = document.getElementById("fm-policy-mga");
const premiumfinancer = document.getElementById("fm-policy-premiumfinancer"); 

function initiate_newpolicyform () {
    coveragetype.value = 0;
    isGrossReceipts.style.display = "none";
    isGrossReceipts_lbl.style.display = "none";
    effective.value = null;
    expiration.value = null;
    carrier.value = null;
    mga.value = null;
    premiumfinancer.value = null;


    applyControlsVisibility (coveragetype.value,isGrossReceipts);
}

premium.addEventListener('keyup', function () {
    computeCommission (commrate.value,this.value,surcharge.value);
    computeSurplusLineTax (this.value,surcharge.value,strate.value);
    computeTotal();
});

strate.addEventListener('keyup', function () {
    computeSurplusLineTax (premium.value,surcharge.value,this.value);
    computeTotal();
});

surcharge.addEventListener('keyup', function () {
    computeCommission (commrate.value,premium.value,this.value);
    computeSurplusLineTax (premium.value,this.value,strate.value);
    computeTotal();
});


commrate.addEventListener('keyup', function () {
    computeCommission (this.value,premium.value,surcharge.value);
    
});

policyfees.addEventListener('keyup', function () {
    computeTotal();
});

mgafees.addEventListener('keyup', function () {
    computeTotal();
});

otherfees.addEventListener('keyup', function () {
    computeTotal();
});

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
coveragetype.addEventListener('change', 
    function () {
        applyControlsVisibility (this.value, isGrossReceipts);
    }
);

isGrossReceipts.addEventListener("change", 
    function () {

        applyControlsVisibility (coveragetype.value, isGrossReceipts);
    }
);



function applyControlsVisibility (coveragetype, isGrossReceipts) {
    switch (coveragetype) {
        case '0':
            isGrossReceipts.style.display = "none";
            isGrossReceipts_lbl.style.display = "none";
            baseperunit.style.display = "none";
            baseperunit_lbl.style.display = "none";
            trailerrate.style.display = "none";
            trailerrate_lbl.style.display = "none";
            duesperunit.style.display = "none";
            duesperunit_lbl.style.display = "none";
            bfrate.style.display = "none";
            bfrate_lbl.style.display = "none";
            brokerfee.style.display = "none";
            brokerfee_lbl.style.display = "none";
            pdrate.style.display = "none";
            pdrate_lbl.style.display = "none";
            notrate.style.display = "none";
            notrate_lbl.style.display = "none";
            tirate.style.display = "none";
            tirate_lbl.style.display = "none";
            premium.style.display = "none";
            premium_lbl.style.display = "none";
            strate.style.display = "none";
            strate_lbl.style.display = "none";
            commrate.style.display = "none";
            commrate_lbl.style.display = "none";
            commission.style.display = "none";
            commission_lbl.style.display = "none";

            break;
        case '1':
        case '2':

            isGrossReceipts.style.display = "inline-block";
            isGrossReceipts_lbl.style.display = "inline-block";
            bfrate.style.display = "inline-block";
            bfrate_lbl.style.display = "inline-block";
            strate.style.display = "inline-block";
            strate_lbl.style.display = "inline-block";
            commrate.style.display = "inline-block";
            commrate_lbl.style.display = "inline-block";

            pdrate.style.display = "none";
            pdrate_lbl.style.display = "none";
            notrate.style.display = "none";
            notrate_lbl.style.display = "none";
            tirate.style.display = "none";
            tirate_lbl.style.display = "none";
            brokerfee.style.display = "none";
            brokerfee_lbl.style.display = "none";

            if (isGrossReceipts.checked) {
                baseperunit.style.display = "none";
                baseperunit_lbl.style.display = "none";
                trailerrate.style.display = "none";
                trailerrate_lbl.style.display = "none";
                duesperunit.style.display = "none";
                duesperunit_lbl.style.display = "none";
                
                premium.style.display = "inline-block";
                premium_lbl.style.display = "inline-block";
                commission.style.display = "inline-block";
                commission_lbl.style.display = "inline-block";
    
            } 
            else {
                baseperunit.style.display = "inline-block";
                baseperunit_lbl.style.display = "inline-block";
                trailerrate.style.display = "inline-block";
                trailerrate_lbl.style.display = "inline-block";
                duesperunit.style.display = "inline-block";
                duesperunit_lbl.style.display = "inline-block";

                premium.style.display = "none";
                premium_lbl.style.display = "none";
                commission.style.display = "none";
                commission_lbl.style.display = "none";
    
            }


            break;
        
            // pd coveragetype            
        case '3': 
            isGrossReceipts.style.display = "inline-block";
            isGrossReceipts_lbl.style.display = "inline-block";
            strate.style.display = "inline-block";
            strate_lbl.style.display = "inline-block";
            commrate.style.display = "inline-block";
            commrate_lbl.style.display = "inline-block";

            baseperunit.style.display = "none";
            baseperunit_lbl.style.display = "none";
            duesperunit.style.display = "none";
            duesperunit_lbl.style.display = "none";
            bfrate.style.display = "none";
            bfrate_lbl.style.display = "none";
            brokerfee.style.display = "none";
            brokerfee_lbl.style.display = "none";

            if (isGrossReceipts.checked) {
                pdrate.style.display = "none";
                pdrate_lbl.style.display = "none";
                trailerrate.style.display = "none";
                trailerrate_lbl.style.display = "none";
                notrate.style.display = "none";
                notrate_lbl.style.display = "none";
                tirate.style.display = "none";
                tirate_lbl.style.display = "none";
                    
                premium.style.display = "inline-block";
                premium_lbl.style.display = "inline-block";
                commission.style.display = "inline-block";
                commission_lbl.style.display = "inline-block";

            } 
            else {
                pdrate.style.display = "inline-block";
                pdrate_lbl.style.display = "inline-block";
                trailerrate.style.display = "inline-block";
                trailerrate_lbl.style.display = "inline-block";
                notrate.style.display = "inline-block";
                notrate_lbl.style.display = "inline-block";
                tirate.style.display = "inline-block";
                tirate_lbl.style.display = "inline-block";

                premium.style.display = "none";
                premium_lbl.style.display = "none";
                commission.style.display = "none";
                commission_lbl.style.display = "none";
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
            trailerrate.style.display = "none";
            trailerrate_lbl.style.display = "none";
            duesperunit.style.display = "none";
            duesperunit_lbl.style.display = "none";        
            bfrate.style.display = "none";
            bfrate_lbl.style.display = "none";
            notrate.style.display = "none";
            notrate_lbl.style.display = "none";
            tirate.style.display = "none";
            tirate_lbl.style.display = "none";

            premium.style.display = "inline-block";
            premium_lbl.style.display = "inline-block";
            strate.style.display = "inline-block";
            strate_lbl.style.display = "inline-block";
            brokerfee.style.display = "inline-block";
            brokerfee_lbl.style.display = "inline-block";
            commrate.style.display = "inline-block";
            commrate_lbl.style.display = "inline-block";
            commission.style.display = "inline-block";
            commission_lbl.style.display = "inline-block";
    
            break;
    }


    // console.log('premium: ' + premium.value);
    // console.log('base per unit: ' + baseperunit.value);
    // console.log('pdrate: ' + pdrate.value);
    // console.log('gross receipts: ' + isGrossReceipts.checked);

}

function computeTotal() {
    let prem = isNaN(premium.value) ? 0 : Number(premium.value);
    let surc = isNaN(surcharge.value) ? 0 : Number(surcharge.value);
    let tax = isNaN(surplustax.value) ? 0 : Number(surplustax.value);
    let polfee = isNaN(policyfees.value) ? 0 : Number(policyfees.value);
    let mgafee = isNaN(mgafees.value) ? 0 : Number(mgafees.value);
    let other = isNaN(otherfees.value) ? 0 : Number(otherfees.value);

    // make premium value to zero if control is hidden
    prem = (premium.style.display == 'none') ? 0 : prem;

    total.value = prem + surc + tax + polfee + mgafee + other;
    total.value = (total.value == 0) ? null : total.value;
}

function computeCommission (commrate,premiumAmnt,surchargeAmnt) {

    let rate = isNaN(commrate) ? 0 : Number(commrate);
    let prem = isNaN(premiumAmnt) ? 0 : Number(premiumAmnt);
    let surc = isNaN(surchargeAmnt) ? 0 : Number(surchargeAmnt);
    let comm = 0;

    // make premium value to zero if control is hidden
    prem = (premium.style.display == 'none') ? 0 : prem;


    comm = (prem + surc) * rate / 100;
    comm = (comm === 0) ? null : comm ;    
    commission.value = comm;
}

function computeSurplusLineTax (premiumAmnt, surcharge, strate) {
    let prem = isNaN(premiumAmnt) ? 0 : Number(premiumAmnt);
    let surc = isNaN(surcharge) ? 0 : Number(surcharge);
    let rate = isNaN(strate) ? 0 : Number(strate);
    let tax = 0;

    // make premium value to zero if control is hidden
    prem = (premium.style.display == 'none') ? 0 : prem;

    tax = (prem + surc) * rate / 100;
    tax = (tax === 0) ? null : tax;
    surplustax.value = tax;    

}

function isValidDate(d) {
    return d instanceof Date && !isNaN(d);
}

