<form action="{{ route('candidate.profile.profile-info-update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                {{-- <div class="col-md-6">
                        <div class="form-group select-style">
                            <label class="font-sm color-text-mutted mb-10">Gender *</label>
                            <select
                                class="form-control form-icons select-active {{ $errors->has('gender') ? 'is-invalid' : '' }}"
                                name="gender" id="">
                                <option value="">Select One</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group select-style">
                            <label class="font-sm color-text-mutted mb-10">Marital Status</label>
                            <select
                                class="form-control form-icons select-active {{ $errors->has('marital_status') ? 'is-invalid' : '' }}"
                                name="marital_status" id="">
                                <option value="">Select One</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                            </select>
                            <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
                        </div>
                    </div> --}}

                <div class="col-md-6">
                    <div class="form-group">
                        <label
                            class="font-sm color-text-mutted mb-10 {{ $errors->has('gender') ? 'is-invalid' : '' }}">Gender
                            *</label>
                        <div class="d-flex">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" name="gender" id="male"
                                    value="male" {{ old('gender', $candidate?->gender) == 'male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female"
                                    value="female"
                                    {{ old('gender', $candidate?->gender) == 'female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label
                            class="font-sm color-text-mutted mb-10 {{ $errors->has('marital_status') ? 'is-invalid' : '' }}">Marital
                            Status</label>
                        <div class="d-flex">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" name="marital_status" id="single"
                                    value="single"
                                    {{ old('marital_status', $candidate?->marital_status) == 'single' ? 'checked' : '' }}>
                                <label class="form-check-label" for="single">Single</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="marital_status" id="married"
                                    value="married"
                                    {{ old('marital_status', $candidate?->marital_status) == 'married' ? 'checked' : '' }}>
                                <label class="form-check-label" for="married">Married</label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group select-style">
                        <label class="font-sm color-text-mutted mb-10">Profession *</label>
                        <select
                            class="form-control form-icons select-active {{ $errors->has('profession') ? 'is-invalid' : '' }}"
                            name="profession" id="">
                            <option value="">Select One</option>
                            @foreach ($professions as $profession)
                                <option @selected($profession->id === $candidate?->profession_id) value="{{ $profession?->id }}">
                                    {{ $profession->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('profession')" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group select-style">
                        <label class="font-sm color-text-mutted mb-10">Your Availability *</label>
                        <select
                            class="form-control form-icons select-active {{ $errors->has('availability') ? 'is-invalid' : '' }}"
                            name="availability" id="">
                            <option value="">Select One</option>
                            <option @selected($candidate?->status === 'available') value="available">Available
                            </option>
                            <option @selected($candidate?->status === 'not_available') value="not_available">Not Available
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('availability')" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group select-style">
                        <label class="font-sm color-text-mutted mb-10">Skills You Have *</label>
                        <select
                            class="{{ $errors->has('skill_you_have') ? 'is-invalid' : '' }} form-icons select-active"
                            name="skill_you_have[]" id="" multiple=''>
                            <option value="">Select One</option>
                            @foreach ($skills as $skill)
                                <option @selected(in_array($skill->id, $candidate?->skills->pluck('skill_id')->toArray() ?? [])) value="{{ $skill?->id }}">{{ $skill?->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('skill_you_have')" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group select-style">
                        <label class="font-sm color-text-mutted mb-10">Languages You Know</label>
                        <select
                            class="{{ $errors->has('language_you_know') ? 'is-invalid' : '' }} form-icons select-active"
                            name="language_you_know[]" id="" multiple=''>
                            <option value="">Select One</option>
                            @foreach ($languages as $language)
                                <option @selected(in_array($language->id, $candidate?->languages->pluck('language_id')->toArray() ?? [])) value="{{ $language?->id }}">
                                    {{ $language?->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('language_you_know')" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-sm color-text-mutted mb-10">Biography *</label>
                        <textarea name="biography" id="editor" class="{{ $errors->has('biography') ? 'is-invalid' : '' }}">{!! $candidate?->bio !!}</textarea>
                        <x-input-error :messages="$errors->get('biography')" class="mt-2" />
                    </div>
                </div>



            </div>
        </div>
        <div class="box-button mt-15">
            <button class="btn btn-apply-big font-md font-bold">Save All Changes</button>
        </div>
    </div>
</form>
