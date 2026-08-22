import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('submit', function (event) {
	const form = event.target.closest('.delete-student-form');

	if (!form || form.dataset.confirmed === 'true') {
		return;
	}

	event.preventDefault();

	Swal.fire({
		title: 'Delete this student?',
		text: `This will permanently remove ${form.dataset.studentName} from the directory.`,
		icon: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Yes, delete',
		cancelButtonText: 'Keep student',
		reverseButtons: true,
		buttonsStyling: false,
		customClass: {
			popup: 'rounded-2xl',
			confirmButton: 'rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white',
			cancelButton: 'mr-3 rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700',
		},
	}).then((result) => {
		if (result.isConfirmed) {
			form.dataset.confirmed = 'true';
			form.submit();
		}
	});
});
