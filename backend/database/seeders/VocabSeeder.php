<?php

namespace Database\Seeders;

use App\Models\VocabSet;
use App\Models\VocabGroup;
use App\Models\Vocabulary;
use Illuminate\Database\Seeder;

class VocabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Vocab Sets (HSK 1-6 + Chengyu & Travel)
        $setsData = [
            [
                'code' => 'H1',
                'title' => 'HSK 1',
                'subtitle' => 'Vỡ lòng – Từ vựng cơ bản nhất học viên mới bắt đầu.',
                'color' => '#10B981', // green
            ],
            [
                'code' => 'H2',
                'title' => 'HSK 2',
                'subtitle' => 'Sơ cấp – Chủ đề giao tiếp, sinh hoạt hằng ngày đơn giản.',
                'color' => '#3B82F6', // blue
            ],
            [
                'code' => 'H3',
                'title' => 'HSK 3',
                'subtitle' => 'Trung cấp – Đọc hiểu đàm thoại, viết câu văn ngắn độc lập.',
                'color' => '#F59E0B', // yellow
            ],
            [
                'code' => 'H4',
                'title' => 'HSK 4',
                'subtitle' => 'Trung-Cao cấp – Giao tiếp trôi chảy với người bản xứ.',
                'color' => '#F97316', // orange
            ],
            [
                'code' => 'H5',
                'title' => 'HSK 5',
                'subtitle' => 'Cao cấp – Đọc báo chí, tạp chí, thưởng thức phim ảnh thoải mái.',
                'color' => '#8B5CF6', // purple
            ],
            [
                'code' => 'H6',
                'title' => 'HSK 6',
                'subtitle' => 'Chuyên sâu – Sử dụng tiếng Trung tự do, viết lách chuyên ngành.',
                'color' => '#EC4899', // pink
            ],
            [
                'code' => 'CD',
                'title' => 'Thành ngữ Trung Quốc',
                'subtitle' => 'Chengyu – Học các câu thành ngữ 4 chữ biểu đạt sâu sắc.',
                'color' => '#06B6D4', // cyan
            ],
            [
                'code' => 'DL',
                'title' => 'Giao tiếp Du lịch',
                'subtitle' => 'Các mẫu câu và từ vựng cấp tốc khi đi du lịch Trung Quốc.',
                'color' => '#6366F1', // indigo
            ]
        ];

        $sets = [];
        foreach ($setsData as $data) {
            $sets[$data['code']] = VocabSet::create($data);
        }

        // 2. Create Vocab Groups and Vocabularies

        // HSK 1
        $h1Set = $sets['H1'];
        $g1 = VocabGroup::create([
            'vocab_set_id' => $h1Set->id,
            'index' => '01',
            'name' => 'Chào hỏi & Đại từ nhân xưng',
            'desc' => 'Các câu chào hỏi giao tiếp cơ bản và xưng hô thông dụng.',
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g1->id,
            'hanzi' => '你',
            'pinyin' => 'nǐ',
            'meaning' => 'Bạn, anh, chị (ngôi thứ 2)',
            'example' => '你好吗？',
            'example_pinyin' => 'Nǐ hǎo ma?',
            'example_meaning' => 'Bạn khỏe không?'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g1->id,
            'hanzi' => '我',
            'pinyin' => 'wǒ',
            'meaning' => 'Tôi, tớ, tao (ngôi thứ 1)',
            'example' => '我是越南人。',
            'example_pinyin' => 'Wǒ shì Yuènánrén.',
            'example_meaning' => 'Tôi là người Việt Nam.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g1->id,
            'hanzi' => '他',
            'pinyin' => 'tā',
            'meaning' => 'Anh ấy, ông ấy (ngôi thứ 3 nam)',
            'example' => '他是我的老师。',
            'example_pinyin' => 'Tā shì wǒ de lǎoshī.',
            'example_meaning' => 'Anh ấy là thầy giáo của tôi.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g1->id,
            'hanzi' => '我们',
            'pinyin' => 'wǒmen',
            'meaning' => 'Chúng tôi, chúng ta',
            'example' => '我们都学习汉语。',
            'example_pinyin' => 'Wǒmen dōu xuéxí Hànyǔ.',
            'example_meaning' => 'Chúng tôi đều học tiếng Trung.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g1->id,
            'hanzi' => '谢谢',
            'pinyin' => 'xièxie',
            'meaning' => 'Cảm ơn',
            'example' => '谢谢你的帮助。',
            'example_pinyin' => 'Xièxie nǐ de bāngzhù.',
            'example_meaning' => 'Cảm ơn sự giúp đỡ của bạn.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g1->id,
            'hanzi' => '她',
            'pinyin' => 'tā',
            'meaning' => 'Cô ấy, bà ấy (ngôi thứ 3 nữ)',
            'example' => '她是我的妈妈。',
            'example_pinyin' => 'Tā shì wǒ de māma.',
            'example_meaning' => 'Cô ấy là mẹ của tôi.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g1->id,
            'hanzi' => '您',
            'pinyin' => 'nín',
            'meaning' => 'Ngài, quý khách (xưng hô tôn trọng)',
            'example' => '老师，您好！',
            'example_pinyin' => 'Lǎoshī, nín hǎo!',
            'example_meaning' => 'Chào thầy/cô!'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g1->id,
            'hanzi' => '不',
            'pinyin' => 'bù',
            'meaning' => 'Không (phủ định)',
            'example' => '我不是学生。',
            'example_pinyin' => 'Wǒ bú shì xuésheng.',
            'example_meaning' => 'Tôi không phải là học sinh.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g1->id,
            'hanzi' => '再见',
            'pinyin' => 'zàijiàn',
            'meaning' => 'Tạm biệt',
            'example' => '妈妈，再见！',
            'example_pinyin' => 'Māma, zàijiàn!',
            'example_meaning' => 'Tạm biệt mẹ!'
        ]);

        $g2 = VocabGroup::create([
            'vocab_set_id' => $h1Set->id,
            'index' => '02',
            'name' => 'Số đếm & Thời gian',
            'desc' => 'Học đếm số cơ bản, ngày tháng và giờ giấc.',
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g2->id,
            'hanzi' => '一',
            'pinyin' => 'yī',
            'meaning' => 'Số một (1)',
            'example' => '我有一只猫。',
            'example_pinyin' => 'Wǒ yǒu yī zhī māo.',
            'example_meaning' => 'Tôi có một con mèo.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g2->id,
            'hanzi' => '十',
            'pinyin' => 'shí',
            'meaning' => 'Số mười (10)',
            'example' => '现在是十点。',
            'example_pinyin' => 'Xiànzài shì shí diǎn.',
            'example_meaning' => 'Bây giờ là mười giờ.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g2->id,
            'hanzi' => '年',
            'pinyin' => 'nián',
            'meaning' => 'Năm',
            'example' => '今年是二零二六年。',
            'example_pinyin' => 'Jīnnián shì èr líng èr liù nián.',
            'example_meaning' => 'Năm nay là năm 2026.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g2->id,
            'hanzi' => '月',
            'pinyin' => 'yuè',
            'meaning' => 'Tháng',
            'example' => '今天是十二月一号。',
            'example_pinyin' => 'Jīntiān shì shí' . "'" . 'èr yuè yī hào.',
            'example_meaning' => 'Hôm nay là ngày 1 tháng 12.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g2->id,
            'hanzi' => '号',
            'pinyin' => 'hào',
            'meaning' => 'Ngày, số',
            'example' => '你的生日是几号？',
            'example_pinyin' => 'Nǐ de shēngrì shì jǐ hào?',
            'example_meaning' => 'Sinh nhật của bạn là ngày mấy?'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g2->id,
            'hanzi' => '星期',
            'pinyin' => 'xīngqī',
            'meaning' => 'Tuần, thứ',
            'example' => '今天星期天。',
            'example_pinyin' => 'Jīntiān xīngqītiān.',
            'example_meaning' => 'Hôm nay là chủ nhật.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g2->id,
            'hanzi' => '点',
            'pinyin' => 'diǎn',
            'meaning' => 'Giờ, điểm',
            'example' => '我们九点上课。',
            'example_pinyin' => 'Wǒmen jiǔ diǎn shàngkè.',
            'example_meaning' => 'Chúng ta học lúc 9 giờ.'
        ]);

        // HSK 2
        $h2Set = $sets['H2'];
        $g3 = VocabGroup::create([
            'vocab_set_id' => $h2Set->id,
            'index' => '01',
            'name' => 'Thời tiết & Mùa',
            'desc' => 'Chủ đề khí hậu, mô tả thời tiết nắng mưa râm mát.',
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g3->id,
            'hanzi' => '晴',
            'pinyin' => 'qíng',
            'meaning' => 'Nắng, trời quang đãng',
            'example' => '今天是晴天。',
            'example_pinyin' => 'Jīntiān shì qíngtiān.',
            'example_meaning' => 'Hôm nay là một ngày nắng.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g3->id,
            'hanzi' => '阴',
            'pinyin' => 'yīn',
            'meaning' => 'Râm mát, nhiều mây, u ám',
            'example' => '明天是阴天。',
            'example_pinyin' => 'Míngtiān shì yīntiān.',
            'example_meaning' => 'Ngày mai trời nhiều mây.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g3->id,
            'hanzi' => '下雨',
            'pinyin' => 'xià yǔ',
            'meaning' => 'Mưa, rơi mưa',
            'example' => '外面下雨了。',
            'example_pinyin' => 'Wàimiàn xià yǔ le.',
            'example_meaning' => 'Bên ngoài trời mưa rồi.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g3->id,
            'hanzi' => '冷',
            'pinyin' => 'lěng',
            'meaning' => 'Lạnh',
            'example' => '今天天气太冷了。',
            'example_pinyin' => 'Jīntiān tiānqì tài lěng le.',
            'example_meaning' => 'Hôm nay thời tiết lạnh quá.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g3->id,
            'hanzi' => '热',
            'pinyin' => 'rè',
            'meaning' => 'Nóng',
            'example' => '北京的夏天很热。',
            'example_pinyin' => 'Běijīng de xiàtiān hěn rè.',
            'example_meaning' => 'Mùa hè ở Bắc Kinh rất nóng.'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g3->id,
            'hanzi' => '下雪',
            'pinyin' => 'xià xuě',
            'meaning' => 'Tuyết rơi',
            'example' => '外面下雪了，好漂亮！',
            'example_pinyin' => 'Wàimiàn xià xuě le, hǎo piàoliang!',
            'example_meaning' => 'Bên ngoài tuyết rơi rồi, đẹp quá!'
        ]);

        Vocabulary::create([
            'vocab_group_id' => $g3->id,
            'hanzi' => '风',
            'pinyin' => 'fēng',
            'meaning' => 'Gió',
            'example' => '刮大风了，快关窗户。',
            'example_pinyin' => 'Guā dàfēng le, kuài guān chuānghu.',
            'example_meaning' => 'Gió to rồi, mau đóng cửa sổ lại.'
        ]);

        // Put placeholder groups for other sets to prevent UI being empty
        foreach ($sets as $code => $setObj) {
            if ($code !== 'H1' && $code !== 'H2') {
                $gPlaceholder = VocabGroup::create([
                    'vocab_set_id' => $setObj->id,
                    'index' => '01',
                    'name' => 'Chương khởi động',
                    'desc' => 'Các từ vựng cốt lõi đầu tiên của học phần.',
                ]);
                Vocabulary::create([
                    'vocab_group_id' => $gPlaceholder->id,
                    'hanzi' => '加油',
                    'pinyin' => 'jiāyóu',
                    'meaning' => 'Cố lên, nỗ lực lên',
                    'example' => '大家加油！',
                    'example_pinyin' => 'Dàjiā jiāyóu!',
                    'example_meaning' => 'Mọi người cố lên!'
                ]);
            }
        }
    }
}
