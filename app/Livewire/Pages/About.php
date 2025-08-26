<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class About extends Component
{
    public array $milestones = [];

    public function mount(): void
    {
        // In a real application, you would fetch this data from the database.
        // For example: $this->milestones = Milestone::orderBy('date')->get()->toArray();
        $this->milestones = [
            ['date' => '2004-03-20', 'title' => '工作室成立', 'description' => '混合無限工作室成立，由最初小型的個人工作室開始做起。'],
            ['date' => '2005-12-12', 'title' => '公司成立', 'description' => '通過申請政府立案，混合無限多媒體有限公司(M-W Multimedia Desing )正式成立。'],
            ['date' => '2007-04-01', 'title' => '專注網站、多媒體', 'description' => '擴展為涵蓋網站整體服務的專業設計公司，為客戶提供網站設計與規劃、網頁程式撰寫、網路行銷、網站優化（SEO）、網站維護、虛擬主機租賃等多元服務。'],
            ['date' => '2008-03-31', 'title' => '台北藝術大學數位典藏', 'description' => '以 Adobe Flex 技術'],
            ['date' => '2009-03-05', 'title' => '中研院數位典藏', 'description' => '以 Adobe Flex 技術'],
            ['date' => '2010-02-06', 'title' => '技術轉型', 'description' => '離開 Adobel Flex / Flash 技術，改採 XHTML、CSS、DOM、jQuery 等技術打造專屬網站模組。'],
            ['date' => '2011-12-09', 'title' => '與教育部合作「學海計劃」', 'description' => '承接教育部'],
            ['date' => '2012-06-22', 'title' => 'Design City x Taipei', 'description' => '由文化大學創意產業中心舉辦之台灣區 TED 活動 Design City x Taipei 網站製作。'],
            ['date' => '2013-03-27', 'title' => '電影－天台', 'description' => '周杰倫電影－「天台」網站製作。'],
            ['date' => '2013-07-09', 'title' => '師大大師－江明賢網路美術館', 'description' => '師大美術系系主任、兩岸國畫名家－江明賢教授之網路美術館。'],
            ['date' => '2014-01-23', 'title' => '台灣藝術治療協會', 'description' => '協助改版「台灣藝術治療協會」官網。'],
            ['date' => '2014-09-25', 'title' => '混合無限拓展', 'description' => '為業務拓展，公司更名為「混合無限智慧科技」，其下轄有「混合無限多媒體」。'],
            ['date' => '2015-03-10', 'title' => '3D 列印', 'description' => '製作 Ctrl+P 之 3D 列印作品平台網站－3Ducation。'],
            ['date' => '2015-06-04', 'title' => '誠品文化藝術基金會', 'description' => '誠品文化藝術基金會「校品閱讀」網站製作。'],
            ['date' => '2015-08-31', 'title' => 'RWD 導入', 'description' => '響應式網頁設計 (Responsive web design) 技術導入網站模組。'],
            ['date' => '2016-07-06', 'title' => 'Amobile RWD Site', 'description' => '聯發科合資成立之 Amobile Solution 磐旭智能網站製作。'],
        ];
    }

    public function render()
    {
        return view('livewire.pages.about');
    }
}
