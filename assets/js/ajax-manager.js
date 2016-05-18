/**
 * Created by apptitudeviet02 on 10/18/14.
 */

$.AjaxQueue = function() {
    this.reqs = [];
    this.requesting = false;
};
$.AjaxQueue.prototype = {
    add: function(req) {
        this.reqs.push(req);
        this.next();
    },
    next: function() {
        if (this.reqs.length == 0) {
            return;
        }

        if (this.requesting == true) {
            return;
        }

        var req = this.reqs.splice(0, 1)[0];
        var complete = req.complete;
        var self = this;

        if (req._run) {
            req._run(req);
        }

        req.complete = function() {
            if (complete) {
                complete.apply(this, arguments);
            }
            self.requesting = false;
            self.next();
        }

        this.requesting = true;
        $.ajax(req);
    }
};