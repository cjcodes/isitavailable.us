require.config({
    baseUrl: 'js/app',
    paths: {
        jquery: '',
        bootstrap: '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js',
    },
    shim: {
        'bootstrap': {
            deps: ['jquery']
        }
    }
})