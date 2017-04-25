/**
 * Created by Keaton on 21.04.2017.
 */



// instantiate the bloodhound suggestion engine
var numbers = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    local:  ["(A)labama","Alaska","Arizona","Arkansas","Arkansas2","Barkansas"]
});
numbers.initialize();

$(".suggest").typeahead({
    items: 4,
    source:numbers.ttAdapter()
});
