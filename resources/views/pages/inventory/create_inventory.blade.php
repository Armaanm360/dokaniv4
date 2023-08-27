
 @extends('home')
 @section('content')
 <!-- Personal Information Card End -->
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title mb-0">Create Inventory</h6>
              </div>
              <div class="card-body">
                <form class="row g-3">
                  <div class="col-lg-4 col-md-6 col-sm-6">
                    <label class="form-label">Company Name</label>
                    <fieldset class="form-icon-group left-icon position-relative">
                      <input type="text" class="form-control">
                      <div class="form-icon position-absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z" />
                          <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z" />
                        </svg>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                    <label class="form-label">Company Number</label>
                    <fieldset class="form-icon-group left-icon position-relative">
                      <input type="text" class="form-control phone-number" placeholder="Ex: (000) 000-00-00">
                      <div class="form-icon position-absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                          <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
                          <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                        </svg>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                    <label class="form-label">Employees</label>
                    <input type="hidden" class="form-control">
                    <fieldset>
                      <select class="array-select form-control form-select" aria-label="example">
                        <option selected>Select Employees</option>
                        <option>0-10</option>
                        <option>11-50</option>
                        <option>51-100</option>
                        <option>100+</option>
                      </select>
                    </fieldset>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                    <label class="form-label">Company Type</label>
                    <select class="form-select array-select form-control" aria-label="example">
                      <option selected>Select Type</option>
                      <option>Real Estate</option>
                      <option>Hospital</option>
                      <option>Information Technology (IT)</option>
                      <option>Goverment</option>
                    </select>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                    <label class="form-label">Joining Date</label>
                    <fieldset class="form-icon-group left-icon position-relative">
                      <input type="text" class="form-control datepicker">
                      <div class="form-icon position-absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                          <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                        </svg>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-6">
                    <label class="form-label">End Date</label>
                    <fieldset class="form-icon-group left-icon position-relative">
                      <input type="text" class="form-control datepicker">
                      <div class="form-icon position-absolute">
                        <svg width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                          <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                        </svg>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary">Save</button>
                    <button class="btn btn-outline-secondary">Cancle</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          @endsection