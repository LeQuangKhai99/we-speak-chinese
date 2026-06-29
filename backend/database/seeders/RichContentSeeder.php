<?php

namespace Database\Seeders;

use App\Models\CommonSentence;
use App\Models\HskListeningTest;
use App\Models\VideoLecture;
use Illuminate\Database\Seeder;

class RichContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Common Sentences
        $sentences = [
            [
                'chinese' => '你好吗？',
                'pinyin' => 'Nǐ hǎo ma?',
                'meaning' => 'Bạn khỏe không?',
                'category' => 'Chào hỏi',
            ],
            [
                'chinese' => '早安，很高兴认识你。',
                'pinyin' => 'Zǎo ān, hěn gāoxìng rènshi nǐ.',
                'meaning' => 'Chào buổi sáng, rất vui được gặp bạn.',
                'category' => 'Chào hỏi',
            ],
            [
                'chinese' => '非常感谢你的帮助。',
                'pinyin' => 'Fēicháng gǎnxiè nǐ de bāngzhù.',
                'meaning' => 'Cảm ơn sự giúp đỡ của bạn rất nhiều.',
                'category' => 'Cảm ơn & Xin lỗi',
            ],
            [
                'chinese' => '对不起, 我迟到了。',
                'pinyin' => 'Duìbuqǐ, wǒ chídào le.',
                'meaning' => 'Xin lỗi, tôi đến muộn.',
                'category' => 'Cảm ơn & Xin lỗi',
            ],
            [
                'chinese' => '没关系，不用客气。',
                'pinyin' => 'Méi guānxi, búyòng kèqi.',
                'meaning' => 'Không sao đâu, đừng khách sáo.',
                'category' => 'Cảm ơn & Xin lỗi',
            ],
            [
                'chinese' => '请问，这个多少钱？',
                'pinyin' => 'Qǐngwèn, zhège duōshǎo qián?',
                'meaning' => 'Xin hỏi, cái này bao nhiêu tiền?',
                'category' => 'Mua sắm & Ăn uống',
            ],
            [
                'chinese' => '我想去火车站，怎么走？',
                'pinyin' => 'Wǒ xiǎng qù huǒchēzhàn, zěnme zǒu?',
                'meaning' => 'Tôi muốn đi ga tàu hỏa, đi thế nào?',
                'category' => 'Giao tiếp hàng ngày',
            ],
            [
                'chinese' => '你会说英文吗？',
                'pinyin' => 'Nǐ huì shuō yīngwén ma?',
                'meaning' => 'Bạn biết nói tiếng Anh không?',
                'category' => 'Giao tiếp hàng ngày',
            ],
            [
                'chinese' => '我的中文不太好。',
                'pinyin' => 'Wǒ de Zhōngwén bú tài hǎo.',
                'meaning' => 'Tiếng Trung của tôi không tốt lắm.',
                'category' => 'Giao tiếp hàng ngày',
            ],
            [
                'chinese' => '祝你今天过得愉快！',
                'pinyin' => 'Zhù nǐ jīntiān guò de yúkuài!',
                'meaning' => 'Chúc bạn ngày hôm nay vui vẻ!',
                'category' => 'Chào hỏi',
            ],
        ];

        foreach ($sentences as $sentence) {
            CommonSentence::create($sentence);
        }

        // 2. Seed HSK Listening Tests
        $tests = [
            [
                'image_path' => '/images/hsk/hsk_listening_1.png',
                'audio_text' => '那只鸟在树枝上展开了翅膀。',
                'correct_option' => 'A',
                'option_a' => '那只鸟在树枝上展开了翅膀。',
                'option_a_meaning' => 'Con chim đó đang sải cánh trên cành cây.',
                'option_b' => '有一只小猫在草地上睡觉。',
                'option_b_meaning' => 'Có một chú mèo con đang ngủ trên bãi cỏ.',
                'option_c' => '水里漂浮着一个红色的皮球。',
                'option_c_meaning' => 'Một quả bóng màu đỏ đang trôi trên mặt nước.',
                'option_d' => '有人在公园里练习打太极拳。',
                'option_d_meaning' => 'Có người đang tập thái cực quyền trong công viên.',
            ],
            [
                'image_path' => '/images/hsk/hsk_listening_2.png',
                'audio_text' => '她正在安静的图书馆里看一本厚书。',
                'correct_option' => 'B',
                'option_a' => '两个女孩正在舞台上唱歌。',
                'option_a_meaning' => 'Hai cô gái đang hát trên sân khấu.',
                'option_b' => '她正在安静的图书馆里看一本厚书。',
                'option_b_meaning' => 'Cô ấy đang đọc một cuốn sách dày trong thư viện yên tĩnh.',
                'option_c' => '医生正在给病人做身体检查。',
                'option_c_meaning' => 'Bác sĩ đang khám sức khỏe cho bệnh nhân.',
                'option_d' => '外面的天气非常冷，下雪了。',
                'option_d_meaning' => 'Thời tiết bên ngoài rất lạnh, tuyết đang rơi.',
            ],
            [
                'image_path' => '/images/hsk/hsk_listening_3.png',
                'audio_text' => '厨师正在厨房里准备美味的晚餐。',
                'correct_option' => 'C',
                'option_a' => '飞机正在天空中慢慢地飞过。',
                'option_a_meaning' => 'Máy bay đang bay qua bầu trời chậm rãi.',
                'option_b' => '小男孩在操场上高兴地踢足球。',
                'option_b_meaning' => 'Cậu bé đang đá bóng vui vẻ trên sân chơi.',
                'option_c' => '厨师正在厨房里准备美味的晚餐。',
                'option_c_meaning' => 'Đầu bếp đang chuẩn bị bữa tối ngon miệng trong nhà bếp.',
                'option_d' => '这条街道上停满了各种颜色的汽车。',
                'option_d_meaning' => 'Con đường này đỗ đầy các loại ô tô đủ màu sắc.',
            ],
            [
                'image_path' => '/images/hsk/hsk_listening_4.png',
                'audio_text' => '他每天早晨都在公园里慢跑锻炼身体。',
                'correct_option' => 'D',
                'option_a' => '老师在黑板上写了很多汉字。',
                'option_a_meaning' => 'Thầy giáo viết rất nhiều chữ Hán lên bảng đen.',
                'option_b' => '售货员在热情地为顾客介绍商品。',
                'option_b_meaning' => 'Nhân viên bán hàng đang nhiệt tình giới thiệu sản phẩm cho khách.',
                'option_c' => '大雨打湿了路边所有的花草树木。',
                'option_c_meaning' => 'Cơn mưa lớn đã làm ướt tất cả hoa cỏ cây cối bên đường.',
                'option_d' => '他每天早晨都在公园里慢跑锻炼身体。',
                'option_d_meaning' => 'Anh ấy chạy bộ trong công viên mỗi sáng để rèn luyện sức khỏe.',
            ],
        ];

        foreach ($tests as $test) {
            HskListeningTest::create($test);
        }

        // 3. Seed Video Lectures
        $videos = [
            [
                'title' => 'Tiếng Trung giao tiếp hằng ngày cho người mới bắt đầu',
                'youtube_id' => '8vEeb-Hn29M',
                'thumbnail_url' => 'https://img.youtube.com/vi/8vEeb-Hn29M/0.jpg',
                'category' => 'Tổng hợp',
                'level' => 'Sơ cấp',
                'video_count' => 50,
            ],
            [
                'title' => 'Học tiếng Trung giao tiếp thông dụng thực tế 100 câu',
                'youtube_id' => 'Zk3U5Q9g9a8',
                'thumbnail_url' => 'https://img.youtube.com/vi/Zk3U5Q9g9a8/0.jpg',
                'category' => 'Tổng hợp',
                'level' => 'Trung cấp',
                'video_count' => 36,
            ],
            [
                'title' => 'Trọn bộ 150 từ vựng HSK 1 kèm câu ví dụ cụ thể',
                'youtube_id' => 'i86v5Nn3qFk',
                'thumbnail_url' => 'https://img.youtube.com/vi/i86v5Nn3qFk/0.jpg',
                'category' => 'Từ vựng',
                'level' => 'Sơ cấp',
                'video_count' => 24,
            ],
            [
                'title' => 'Tổng hợp ngữ pháp HSK 2: Cấu trúc câu và cách dùng chi tiết',
                'youtube_id' => 'pDk3R-12u14',
                'thumbnail_url' => 'https://img.youtube.com/vi/pDk3R-12u14/0.jpg',
                'category' => 'Ngữ pháp',
                'level' => 'Sơ cấp',
                'video_count' => 20,
            ],
            [
                'title' => 'Luyện nghe thụ động tiếng Trung chuẩn HSK 3 (Mưa nhẹ)',
                'youtube_id' => '7v-p2qJp7o8',
                'thumbnail_url' => 'https://img.youtube.com/vi/7v-p2qJp7o8/0.jpg',
                'category' => 'Luyện nghe',
                'level' => 'Trung cấp',
                'video_count' => 16,
            ],
            [
                'title' => 'Luyện nói phản xạ tiếng Trung giao tiếp cấp tốc nâng cao',
                'youtube_id' => 'L0Q3Q_L9uOQ',
                'thumbnail_url' => 'https://img.youtube.com/vi/L0Q3Q_L9uOQ/0.jpg',
                'category' => 'Luyện nói',
                'level' => 'Cao cấp',
                'video_count' => 38,
            ],
        ];

        foreach ($videos as $video) {
            VideoLecture::create($video);
        }
    }
}
