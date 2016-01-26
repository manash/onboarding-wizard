<div class="container"
     ng-show="1 == store.setupDetail.wizardStep || store.setupDetail.wizardStep > store.setupDetail.storeSetupOrder.length">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="tab-content">
                <form accept-charset="UTF-8" name="addStore" action="/" class="require-validation" method="post">
                    <div class='form-row'>
                        <div class='form-group required' ng-class="{'has-error' : store.setupError}">
                            <label class='control-label'>Store Name</label>
                            <input class='form-control' size='20' type='text' ng-model="store.detail.name"
                                   ng-blur="store.checkIfStorePresent()" ng-disabled="store.setupDetail.storeId">
                            <span class="help-block text-danger" ng-show="store.setupError" ng-bind="store.setupError"></span>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group required'>
                            <label class='control-label'>Store Address</label>
                            <textarea class='form-control' ng-model="store.detail.address"></textarea>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group required'>
                            <label class='control-label'>City</label>
                            <input class='form-control' size='20' type='text' ng-model="store.detail.city">
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group required'>
                            <label class='control-label'>Pincode</label>
                            <input class='form-control' size='20' type='text' maxlength=6 ng-model="store.detail.pin">
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group required'>
                            <label class='control-label'>Phone No.</label>
                            <input class='form-control' size='20' type='text' maxlength=10 ng-model="store.detail.phone">
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group'>
                            <label class='control-label'></label>
                            <button class='form-control btn btn-primary' type='button' ng-click="store.saveStoreDetails();"> Continue →</button>
                        </div>
                    </div>

                    <div id="skip" ng-hide="store.setupDetail && store.setupDetail.wizardStepDetail &&
                        0 == store.setupDetail.wizardStepDetail[store.setupDetail.storeSetupOrder[0]]['skippable']">
                        <a>Skip this step >>> </a>
                    </div>
                    <div class='form-row'><div class='form-group'></div></div>
                </form>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>