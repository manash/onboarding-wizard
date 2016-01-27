<div class="container" ng-cloak
     ng-show="1 == store.setupDetail.wizardStep || store.setupDetail.wizardStep > store.setupDetail.storeSetupOrder.length">
    <div class="row">
        <div class="col-sm-6">
            <div class="tab-content">
                <form accept-charset="UTF-8" name="addStore" action="/" class="require-validation" method="post">
                    <p class="text-danger" ng-show="store.setupError" ng-bind="store.setupError"></p>

                    <div class='form-row'>
                        <div class='form-group required' ng-class="{'has-error' : -1 !== store.errorFields.indexOf('name')}">
                            <label class='control-label'>Store Name</label>
                            <input class='form-control' size='20' type='text' ng-model="store.detail.name"
                                   ng-blur="store.checkIfStorePresent()" ng-disabled="store.setupDetail.storeId"
                                   uib-tooltip="The most vital of all, enter your store name"
                                   tooltip-placement="top" tooltip-trigger="mouseenter" tooltip-enable="!store.detail.name" required>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group required' ng-class="{'has-error' : -1 !== store.errorFields.indexOf('address')}">
                            <label class='control-label'>Store Address</label>
                            <textarea class='form-control' ng-model="store.detail.address"
                                      uib-tooltip="Address, how can someone find you without it??"
                                      tooltip-placement="top" tooltip-trigger="mouseenter" tooltip-enable="!store.detail.address" required></textarea>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group required' ng-class="{'has-error' : -1 !== store.errorFields.indexOf('city')}">
                            <label class='control-label'>City</label>
                            <input class='form-control' size='20' type='text' ng-model="store.detail.city"
                                   uib-tooltip="The city where your store is"
                                   tooltip-placement="top" tooltip-trigger="mouseenter" tooltip-enable="!store.detail.city" required>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group required' ng-class="{'has-error' : -1 !== store.errorFields.indexOf('pin')}">
                            <label class='control-label'>Pincode</label>
                            <input class='form-control' size='20' type='text' maxlength=6 ng-model="store.detail.pin"
                                   uib-tooltip="Pincode, to help us identify the area"
                                   tooltip-placement="top" tooltip-trigger="mouseenter" tooltip-enable="!store.detail.name" required>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group required' ng-class="{'has-error' : -1 !== store.errorFields.indexOf('phone')}">
                            <label class='control-label'>Phone No.</label>
                            <input class='form-control' size='20' type='text' maxlength=10 ng-model="store.detail.phone"
                                   uib-tooltip="Phone number for your customer"
                                   tooltip-placement="top" tooltip-trigger="mouseenter" tooltip-enable="!store.detail.name" required>
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
        <div class="col-sm-6">
            <h3 class="dark-grey">What are these, why should I fill these??</h3>
            <p>
                Enter the details, such as name, address, city, pincode & phone number to add the store. Remember all the fields are mandatory & must be filled. Help texts has been provided to make the onboarding process smoother.
            </p>
            <p>
                Your detail will help us at Opinio in setting your business & reach out to the proper audience. The tool is a mean to collect proper authentic data from owner to help them spread their business.
            </p>
            <p>
                Incase you have some query or concern do write a mail to <a href="mailto:support@opinio.com">support@opinio.com</a> or call us at <a href="tel:+91-9686935485">+91-9686935485</a>
            </p>
        </div>
    </div>
</div>