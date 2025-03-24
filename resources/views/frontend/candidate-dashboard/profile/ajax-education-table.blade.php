@foreach ($candidateEducations as $candidateEducation)
    <tr>
        <td>{{ $candidateEducation->level }}</td>
        <td>{{ $candidateEducation->degree }}</td>
        <td>{{ $candidateEducation->year }}</td>
        <td>
            <a href="{{ route('candidate.education.edit', $candidateEducation->id) }}"
                class="btn-sm btn btn-primary edit-education" data-bs-toggle="modal" data-bs-target="#educationModal"><i
                    class="fas fa-edit"></i></a>
            <a href="{{ route('candidate.education.destroy', $candidateEducation->id) }}"
                class="btn-sm btn btn-danger delete-education"><i class="fas fa-trash-alt"></i></a>
        </td>
    </tr>
@endforeach
