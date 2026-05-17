document.addEventListener('DOMContentLoaded', function () {

    const dateInput = document.getElementById('booking-date');

    const slotGrid = document.getElementById('time-slot-grid');

    const hiddenTimeInput = document.getElementById('selected-start-time');

    // Nếu không phải trang booking thì dừng
    if (!dateInput || !slotGrid || !hiddenTimeInput) {
        return;
    }

    dateInput.addEventListener('change', async function () {

        const serviceId =
            document.querySelector('input[name="service_id"]').value;

        const date = this.value;

        if (!date) return;

        slotGrid.innerHTML = `
            <p class="col-span-4 text-sm">
                Đang tải khung giờ...
            </p>
        `;

        try {

            const response = await fetch(
                `/appointments/slots?service_id=${serviceId}&date=${date}`
            );

            const slots = await response.json();

            slotGrid.innerHTML = '';

            slots.forEach(slot => {

                const btn = document.createElement('button');

                btn.type = 'button';

                btn.innerText = slot.time;

                let classes =
                    "w-full py-4 text-sm font-medium border transition ";

                // Chỉ render UI
                // Không xử lý business logic tại frontend
                if (slot.available) {

                    classes +=
                        "border-slate-300 hover:border-green-600 slot-btn-active shadow-sm";

                    btn.onclick = () => selectSlot(btn, slot.time);

                } else {

                    classes +=
                        "bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed opacity-50";

                    btn.disabled = true;

                    if (slot.label) {

                        btn.innerHTML += `
                            <br>
                            <span class="text-[10px]">
                                ${slot.label}
                            </span>
                        `;
                    }
                }

                btn.className = classes;

                slotGrid.appendChild(btn);
            });

        } catch (error) {

            console.error(error);

            slotGrid.innerHTML = `
                <p class="text-red-500">
                    Lỗi tải khung giờ!
                </p>
            `;
        }
    });

    function selectSlot(btn, time) {

        document.querySelectorAll('#time-slot-grid button')
            .forEach(b => {

                b.classList.remove(
                    'bg-[#A8BCA1]',
                    'text-white',
                    'border-transparent'
                );

                b.classList.add('border-slate-300');
            });

        btn.classList.remove('border-slate-300');

        btn.classList.add(
            'bg-[#A8BCA1]',
            'text-white',
            'border-transparent'
        );

        hiddenTimeInput.value =
            dateInput.value + ' ' + time + ':00';
    }
});