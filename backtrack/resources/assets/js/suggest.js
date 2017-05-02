/**
 * Created by Keaton on 21.04.2017.
 */
require('./components/typeahead.jquery');
var Bloodhound = require('./components/bloodhound');


// instantiate the bloodhound suggestion engine
var songs = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: '/search/%QUERY.json',
        wildcard: '%QUERY'
    }
});

$(".suggest").typeahead(null, {
    name: 'songs',
    display: 'name',
    source:songs
});
