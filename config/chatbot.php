<?php

return [
    // Cấu hình cho chatbot tư vấn dịch vụ
    'categories' => [

        'skincare' => [
            'id' => 1, // ID category trong DB để ưu tiên tìm kiếm dịch vụ
            'triggers' => [
                // Tình trạng da
                'mụn', 'mụn trứng cá', 'xỉn màu', 'thiếu sức sống', 'thâm', 'lão hóa', 'sạm', 'sẹo mụn', 
                'nếp nhăn', 'chảy xệ', 'đau rát', 'da mệt mỏi', 'tối màu', 'không đều màu',
                // Nhu cầu & Tình huống
                'da mặt', 'dưỡng da', 'dưỡng da mặt', 'chăm sóc da', 'trẻ hóa', 'nâng cơ', 'săn chắc', 'mịn màng', 
                'cấp ẩm', 'làm sạch sâu', 'thanh lọc', 'bận rộn', 'nhanh', 'ít thời gian', 'cấp tốc'
            ],

            'keywords' => [
                'mài mòn vi kim cương', 'kim cương', 'microdermabrasion',
                'hydra', 'led', 'oxy', 'dna cá hồi',
                'ngọc bích', 'comforzone', 'hoa cúc', 'hoa nam',
                'chăm sóc da mặt', 'chăm sóc da mặt nhanh', 'da mặt nhanh'
            ],

            'reply' => 'BerryNice gợi ý :services giúp làm sạch sâu, hỗ trợ cải thiện các vấn đề về da mặt và mang lại làn da tươi trẻ, rạng rỡ hơn 🥰',
        ],

        'haircare' => [
            'id' => 2,
            'triggers' => [
                'tóc', 'gội đầu', 'rụng tóc', 'da đầu', 'tóc khô', 'tóc xơ', 'ngứa đầu', 'gàu', 'gội thảo dược', 
                'tóc hư tổn', 'ngứa đầu', 'gàu', 'gội thảo dược', 'gội dưỡng sinh', 'phục hồi tóc', 'u tóc', 'duỗi tóc', 'hấp tóc', 'dưỡng tóc', 'phục hồi tóc hư tổn'
            ],

            'keywords' => [
                'gội đầu truyền thống', 'shiradhara', 'keratin', 'hấp làm mượt tóc', 
                'ayurvedic', 'bấm huyệt đầu', 'thảo dược tự nhiên'
            ],

            'reply' => 'BerryNice gợi ý :services giúp chăm sóc tóc sâu từ nang nuôi dưỡng, phục hồi tóc hư tổn và mang lại cảm giác thư thái cho da đầu 🌿',
        ],

        'massage' => [
            'id' => 3,
            'triggers' => [
                // Triệu chứng cơ thể
                'đau vai gáy', 'mệt', 'stress', 'thư giãn', 'căng thẳng', 'đau nhức', 'mỏi cơ', 
                'mất ngủ', 'uể oải', 'đau lưng', 'cột sống', 'co cứng cơ', 'mãn tính',
                // Nhu cầu
                'massage', 'đấm bóp', 'trị liệu', 'bấm huyệt', 'body', 'toàn thân', 'ấn huyệt', 'khí huyết', 'lưu thông máu', 
                'phục hồi năng lượng', 'giải tỏa căng thẳng cơ bắp', 'giảm đau nhức', 'phục hồi năng lượng toàn thân', 'cơ thể', 'thư giãn toàn thân'
            ],

            'keywords' => [
                'massage trị liệu', 'body&soul', 'bali', 'thụy điển', 'shiatsu',
                'massage truyền thống', 'thảo dược', 'ngải cứu', 'gừng',
                'mô sâu', 'áp lực sâu', 'lưu thông máu'
            ],

            'reply' => 'BerryNice gợi ý :services giúp giải tỏa căng thẳng cơ bắp, giảm đau nhức và phục hồi năng lượng toàn thân hiệu quả ✨',
        ],

        'bodyscrub' => [ // Tách riêng danh mục tẩy tế bào chết body để tránh gợi ý nhầm sang gói mặt
            'id' => 4,
            'triggers' => [
                'tẩy tế bào chết body', 'tẩy da chết toàn thân', 'sần sùi', 'thô ráp', 
                'bột cà phê', 'muối gừng', 'muối hữu cơ', 'mịn da body'
            ],
            'keywords' => [
                'just body polish', 'muối hữu cơ', 'muối gừng', 'cà phê hữu cơ', 'tẩy tế bào chết body'
            ],
            'reply' => 'BerryNice gợi ý các dịch vụ tẩy tế bào chết toàn thân :services giúp loại bỏ lớp da thô ráp, làm mịn và chuẩn bị tốt nhất cho các bước dưỡng body sau đó 🌸',
        ],

        'waxing' => [
            'id' => 5,
            'triggers' => [
                'wax', 'lông', 'triệt lông', 'nhổ lông', 'dọn lông', 'rậm lông',
                'wax tay', 'wax chân', 'wax mặt', 'violong', 'kích ứng', 'tẩy lông'
            ],

            'keywords' => [
                'tẩy lông mặt', 'tẩy lông toàn bộ cánh tay', 'tẩy lông toàn bộ chân', 'wax lông'
            ],

            'reply' => 'BerryNice gợi ý :services giúp làm sạch các vùng lông không mong muốn một cách an toàn và hạn chế tối đa kích ứng da 🌸',
        ],

        'whitening' => [
            'id' => 6,
            'triggers' => [
                'trắng da', 'tắm trắng', 'bật tone', 'sáng da', 'trắng hồng', 
                'nhả nắng', 'cháy nắng', 'sữa dê', 'lựu đỏ', 'cherry', 'đều màu body', 'đều màu da', 'trắng da body', 'trắng da toàn thân', 'cấp trắng', 'tắm thảo dược'
            ],

            'keywords' => [
                'tắm trắng sữa dê', 'tắm cấp trắng cherry tuyết', 'bông spa'
            ],

            'reply' => 'BerryNice gợi ý :services hỗ trợ thanh tẩy chuyên sâu, nuôi dưỡng làn da body trắng sáng hồng hào và mịn màng như em bé ✨',
        ],
    ],
];