pimcore.registerNS("pimcore.plugin.subdomainadmin");

pimcore.plugin.subdomainadmin = Class.create(pimcore.plugin.admin, {
    getClassName: function() {
        return "pimcore.plugin.subdomainadmin";
    },

    initialize: function() {
        pimcore.plugin.broker.registerPlugin(this);
    },
 
    pimcoreReady: function (params,broker){
        // alert("SubdomainAdmin Ready!");
    }
});

var subdomainadminPlugin = new pimcore.plugin.subdomainadmin();

