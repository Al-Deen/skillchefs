<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Modules\CMS\Interfaces\FooterInterface;
use Modules\Forum\Interfaces\ForumCategoryInterface;
use Modules\Forum\Interfaces\ForumQuestionInterface;

class ForumSideBarComposer
{

    public $forumQuestion;
    public $forumCategory;

    public function __construct(
        ForumCategoryInterface $forumCategoryRepository,
        ForumQuestionInterface $forumQuestionRepository) {
        $this->forumQuestion = $forumQuestionRepository;
        $this->forumCategory = $forumCategoryRepository;
    }

    public function compose(View $view)
    {

        $data['categories'] = $this->forumCategory->getActive();
        $data['featured_questions'] = $this->forumQuestion->featured();
        $view->with('data', $data);
    }
}
