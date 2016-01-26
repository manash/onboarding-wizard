<div class="container" ng-show="2 == store.setupDetail.wizardStep">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <p class="lead">
                Please add few menu items for store
                <mark><span ng-bind="store.setupDetail.storeName"></span></mark>
            </p>
            <form class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Menu Name" ng-model="store.newitem.name">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Price" ng-model="store.newitem.price">
                </div>

                <div class="form-group"></div>
                <button type="button" class="btn btn-primary" ng-click="store.saveItem();">Add</button>
            </form>
            <br>
            <div class="form-group">
                <button class='btn btn-primary' type='button' ng-click="store.continueToDashboard();"> Continue →</button>
            </div>
            <div id="skip">
                <a style="float:left;" ng-click="store.goBack()"> <<< Go Back </a>
                <a ng-show="store.setupDetail && store.setupDetail.wizardStepDetail &&
                   1 == store.setupDetail.wizardStepDetail[store.setupDetail.storeSetupOrder[1]]['skippable']"
                   ng-click="store.skipStep('2');">
                    Skip this step >>>
                </a>
            </div>
        </div>
        <div class="col-sm-3"></div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Menu Name</th>
                    <th>Price</th>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="(key, item) in store.addedItems track by $index">
                    <th scope="row" ng-bind="(key + 1)"></th>
                    <td ng-bind="item[0]"></td>
                    <td ng-bind="item[1] | currency:'&#8377;'"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>