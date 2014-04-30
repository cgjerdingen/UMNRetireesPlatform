// constructs the suggestion engine
var people = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('fullname'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url:'/persons?q=%QUERY',
    filter: function (parsedResponse) {
      console.log(parsedResponse);
      return parsedResponse.persons;
    }
  }
});

// kicks off the loading/processing of `local` and `prefetch`
people.initialize();

$('#peopleSearch').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'persons',
  displayKey: 'fullname',
  source: people.ttAdapter(),
  templates: {
    empty: [
      '<div class="alert alert-danger">',
      'Unable to find any members that match the current query',
      '</div>'
    ].join('\n'),
    suggestion: Handlebars.compile('<p><strong><a href="/person/{{id}}">{{fullname}}</a></strong></p>')
  }
});

$('#peopleSearch').bind('typeahead:selected', function (obj, datum) {
  window.location = "/person/" + datum.id;
});
