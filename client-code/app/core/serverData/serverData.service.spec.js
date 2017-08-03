'use strict';

describe('ServerData', function() {
  var $httpBackend;
  var Phone;
  var serverData = [
    {name: 'ServerData X'},
    {name: 'ServerData Y'},
    {name: 'ServerData Z'}
  ];

  // Add a custom equality tester before each test
  beforeEach(function() {
    jasmine.addCustomEqualityTester(angular.equals);
  });

  // Load the module that contains the `Phone` service before each test
  beforeEach(module('core.serverData'));

  // Instantiate the service and "train" `$httpBackend` before each test
  beforeEach(inject(function(_$httpBackend_, _Phone_) {
    $httpBackend = _$httpBackend_;
    $httpBackend.expectGET('phones/phones.json').respond(serverData);

    Phone = _Phone_;
  }));

  // Verify that there are no outstanding expectations or requests after each test
  afterEach(function () {
    $httpBackend.verifyNoOutstandingExpectation();
    $httpBackend.verifyNoOutstandingRequest();
  });

  it('should fetch the phones data from `/phones/phones.json`', function() {
    var serverData = ServerData.query();

    expect(serverData).toEqual([]);

    $httpBackend.flush();
    expect(serverData).toEqual(serverData);
  });

});
