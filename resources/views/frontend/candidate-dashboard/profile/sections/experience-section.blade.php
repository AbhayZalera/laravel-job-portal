<div>
    <div class="d-flex justify-content-between">
        <h4>Experience</h4>
        <button class="btn btn-primary" onclick="$('#ExperienceForm').trigger('reset'); editID= '';" data-bs-toggle="modal"
            data-bs-target="#experienceModal">Add Experience</button>
    </div>

    <table class="table table-striped table-hover">
        <br>
        <thead>
            <tr>
                <th>Company</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Period</th>
                <th style="width: 15%">Action</th>
            </tr>
        </thead>
        <tbody class="experience-tbody">
            {{-- @foreach ($candidateExperiences as $candidateExperience)
            <tr>
                <td>{{ $candidateExperience->company }}</td>
                <td>{{ $candidateExperience->department }}</td>
                <td>{{ $candidateExperience->designation }}</td>
                <td>{{ $candidateExperience->start }} -
                    {{ $candidateExperience->currently_working === 1 ? 'Current' : $candidateExperience->end }}</td>
                <td>
                    <a href="{{ route('candidate.experience.edit', $candidateExperience->id) }}"
                        class="btn-sm btn btn-primary edit-experience" data-bs-toggle="modal"
                        data-bs-target="#experienceModal"><i class="fas fa-edit"></i></a>
                    <a href="{{ route('candidate.experience.destroy', $candidateExperience->id) }}"
                        class="btn-sm btn btn-danger delete-experience"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        @endforeach --}}
        </tbody>
    </table>
</div>
{{-- =================================================================================================== --}}
<br><br>
<div>
    <div class="d-flex justify-content-between">
        <h4>Education</h4>
        <button class="btn btn-primary" onclick=" $('#EducationForm').trigger('reset'); editID= '';"
            data-bs-toggle="modal" data-bs-target="#educationModal">Add Education</button>
    </div>

    <table class="table table-striped table-hover">
        <br>
        <thead>
            <tr>
                <th>Level</th>
                <th>Degree</th>
                <th>Year</th>
                <th style="width: 15%">Action</th>
            </tr>
        </thead>
        <tbody class="education-tbody">
            {{-- @foreach ($candidateEducations as $candidateEducation)
                <tr>
                    <td>{{ $candidateEducation->level }}</td>
                    <td>{{ $candidateEducation->degree }}</td>
                    <td>{{ $candidateEducation->year }}</td>
                    <td>{{ $candidateEducation->note }}</td>
                    <td>
                        <a href="{{ route('candidate.education.edit', $candidateEducation->id) }}"
                            class="btn-sm btn btn-primary edit-education" data-bs-toggle="modal"
                            data-bs-target="#educationModal"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('candidate.education.destroy', $candidateEducation->id) }}"
                            class="btn-sm btn btn-danger delete-education"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
</div>
