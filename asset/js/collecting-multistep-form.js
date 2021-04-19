let stepIndex = 0;
let fieldsets;

$(document).ready(function() {
    fieldsets = $("fieldset");

    fieldsets.addClass('hidden');
    fieldsets.first().removeClass('hidden');

    console.log(`Found ${fieldsets.length} fieldsets`);

    $(":button[name='prev']").click(function () {
        console.log(`Clicked Previous, stepIndex = ${stepIndex}`);
        fieldsets.eq(stepIndex).addClass('hidden');
        stepIndex--;
        fieldsets.eq(stepIndex).removeClass('hidden');
    });

    $(":button[name='next']").click(function () {
        console.log(`Clicked Next, stepIndex = ${stepIndex}`);
        fieldsets.eq(stepIndex).addClass('hidden');
        stepIndex++;
        fieldsets.eq(stepIndex).removeClass('hidden');
    });

});


// function incrementStep() {
//     stepIndex++;
//     for(const step of steps) {
//         step.classList.add('hidden');
//     }
//     steps.eq(stepIndex).classList.remove('hidden');
// }