<div class="row mb-2">
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input name="name" value="{{ old('name',$branch->name ?? '') }}" label="Branch Name" placeholder="Enter Username"  required="true" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input name="email" value="{{ old('email', $branch->email ?? '') }}" label="Email" placeholder="Enter Email"  required="true" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input name="contact" value="{{ old('contact', $branch->contact ?? '') }}" label="Contact" placeholder="Enter Contact"  required="true" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input name="location" value="{{ old('location', $branch->location ?? '') }}" label="Location" placeholder="Enter Location"  required="true" />
        </div>
    </div>
    <div class="col-md-4">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="Active" @isset($branch) @selected($branch->status == 'Active') @endisset>Active</option>
            <option value="Inactive" @isset($branch) @selected($branch->status == 'Inactive') @endisset>Inactive</option>
        </select>
    </div>
</div>
<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>