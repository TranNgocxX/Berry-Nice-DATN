@extends('layouts.app')

@section('title', 'Đặt lịch hẹn')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12 bg-[#FDFBF0]">

    <!-- Header -->
    <div class="bg-[#A8BCA1] text-white px-8 py-6 mb-10 rounded">
        <h2 class="text-2xl font-semibold">Đặt lịch hẹn</h2>
        <p class="text-white/80 text-sm mt-1">Vui lòng điền thông tin chính xác</p>
    </div>

    @if(session('success'))
        <div class="mb-8 bg-emerald-50 border border-emerald-300 text-emerald-700 px-6 py-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-8 bg-red-50 border border-red-300 text-red-700 px-6 py-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('appointment.store') }}" method="POST" id="booking-form">
        @csrf
        <input type="hidden" name="service_id" value="{{ $service->id }}">

        <!-- Thông tin dịch vụ -->
        <div class="mb-10 p-6 bg-[#DDEAD1] rounded">
            <p class="text-xs font-medium text-slate-600 mb-2">DỊCH VỤ ĐÃ CHỌN</p>
            <h3 class="text-xl font-semibold">{{ $service->name }}</h3>
            <p class="text-green-700 mt-1">
                {{ $service->duration }} phút • {{ number_format($service->price) }}đ
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Chọn ngày -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ngày hẹn <span class="text-red-500">*</span></label>
                <input type="date" 
                       id="booking-date"
                       name="date"
                       value="{{ old('date') }}"
                       min="{{ now()->toDateString() }}"
                       class="w-full px-5 py-4 border @error('date') border-red-400 @else border-green-300 @enderror focus:border-green-600 outline-none bg-white">
                @error('date')
                    <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Chọn khung giờ -->
            <div class="grid grid-cols-4 gap-3" id="time-slot-grid">
                <p class="col-span-4 text-slate-400 text-sm italic">Vui lòng chọn ngày để xem khung giờ...</p>
            </div>
            <input type="hidden" name="start_time" id="selected-start-time" value="{{ old('start_time') }}">

        </div>

        <!-- Thông tin khách hàng -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Họ và tên <span class="text-red-500">*</span></label>
                <input type="text" name="customer_name"
                       value="{{ old('customer_name', auth()->check() ? auth()->user()->name : '') }}"
                       class="w-full px-5 py-4 border @error('customer_name') border-red-400 @else border-green-300 @enderror focus:border-green-600 outline-none bg-white">
                @error('customer_name')
                    <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Số điện thoại <span class="text-red-500">*</span></label>
                <input type="text" name="phone"
                       value="{{ old('phone') }}"
                       class="w-full px-5 py-4 border @error('phone') border-red-400 @else border-green-300 @enderror focus:border-green-600 outline-none bg-white"
                       placeholder="0987654321">
                @error('phone')
                    <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Tình trạng sức khỏe</label>
            <textarea name="health_status" rows="2" 
                      class="w-full px-5 py-4 border border-green-300 focus:border-green-600 outline-none bg-white">{{ old('health_status') }}</textarea>
        </div>

        <div class="mt-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Ghi chú thêm</label>
            <textarea name="notes" rows="3" 
                      class="w-full px-5 py-4 border border-green-300 focus:border-green-600 outline-none bg-white">{{ old('notes') }}</textarea>
        </div>

        <!-- Thanh toán -->
        <div class="mt-8">
            <label class="block text-sm font-semibold text-slate-700 mb-3">Hình thức thanh toán <span class="text-red-500">*</span></label>
            <div class="grid grid-cols-2 gap-4">
                <label class="cursor-pointer">
                    <input type="radio" name="payment_method" value="cash" checked class="peer hidden">
                    <div class="payment-option border-2 border-green-300 peer-checked:border-green-600 rounded p-6 text-center hover:bg-green-50 transition">💵 Tiền mặt</div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="payment_method" value="qr" class="peer hidden">
                    <div class="payment-option border-2 border-green-300 peer-checked:border-green-600 rounded p-6 text-center hover:bg-green-50 transition">📱 Chuyển khoản QR</div>
                </label>
            </div>
            @error('payment_method')
                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" 
                class="mt-12 w-full bg-[#A8BCA1] hover:bg-[#8FAF8C] text-white py-5 text-lg font-semibold transition">
            XÁC NHẬN ĐẶT LỊCH
        </button>
    </form>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('booking-date');
    const slotGrid = document.getElementById('time-slot-grid');
    const hiddenTimeInput = document.getElementById('selected-start-time');

    dateInput.addEventListener('change', async function () {
        const serviceId = document.querySelector('input[name="service_id"]').value;
        const date = this.value;

        if (!date) return;

        slotGrid.innerHTML = '<p class="col-span-4 text-sm">Đang tải khung giờ...</p>';

        try {
            const response = await fetch(`/appointments/get-slots?service_id=${serviceId}&date=${date}`);
            const slots = await response.json();

            slotGrid.innerHTML = ''; // Clear loading

            // Lấy thời gian hiện tại để so sánh
            const now = new Date();
            const selectedDate = new Date(date);
            const isToday = now.toDateString() === selectedDate.toDateString();

            slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.innerText = slot.time;
                
                let classes = "w-full py-4 text-sm font-medium border transition ";
                
                // Logic kiểm tra giờ đã qua
                let isPast = false;
                if (isToday) {
                    const [hours, minutes] = slot.time.split(':');
                    const slotDateTime = new Date(selectedDate);
                    slotDateTime.setHours(parseInt(hours), parseInt(minutes), 0);
                    
                    if (slotDateTime <= now) {
                        isPast = true;
                    }
                }

                // Kết hợp điều kiện: Phải còn chỗ (available) VÀ chưa trôi qua (not isPast)
                if (slot.available && !isPast) {
                    classes += "border-slate-300 hover:border-green-600 slot-btn-active shadow-sm";
                    btn.onclick = () => selectSlot(btn, slot.time);
                } else {
                    classes += "bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed opacity-50";
                    btn.disabled = true;
                    
                    // Hiển thị nhãn tương ứng
                    if (isPast) {
                        btn.innerHTML += '<br><span class="text-[10px]">Đã qua</span>';
                    } else {
                        btn.innerHTML += '<br><span class="text-[10px]">Hết chỗ</span>';
                    }
                }

                btn.className = classes;
                slotGrid.appendChild(btn);
            });
        } catch (error) {
            slotGrid.innerHTML = '<p class="text-red-500">Lỗi tải khung giờ!</p>';
        }
    });

    function selectSlot(btn, time) {
        document.querySelectorAll('#time-slot-grid button').forEach(b => {
            b.classList.remove('bg-[#A8BCA1]', 'text-white', 'border-transparent');
            b.classList.add('border-slate-300');
        });
        btn.classList.remove('border-slate-300');
        btn.classList.add('bg-[#A8BCA1]', 'text-white', 'border-transparent');
        hiddenTimeInput.value = dateInput.value + ' ' + time + ':00';
    }
});
</script>