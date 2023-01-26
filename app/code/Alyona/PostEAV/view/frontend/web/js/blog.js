define(['uiComponent'], function (Component){
    "use strict";
    return Component.extend({
        defaults:{
            template:"Alyona_PostEAV/blog"
        },

        initialize: function (){
            this._super();
            return this;
        },

        getDate: function (value){
            const date = new Date(value);
            const formatter = new Intl.DateTimeFormat('en', {month:'short'})
            const month = formatter.format(date);
            return month + ' '+ date.getDay() + ', ' +date.getFullYear();
        }
    });
});
