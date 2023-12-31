<?php

namespace App\DataFixtures;

use App\Entity\Comments;
use App\Entity\News;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $password = $this->hasher->hashPassword($user, '11111111');
        $user->setLogin('admin');
        $user->setEmail('admin@mail.ru');
        $user->setRoles([
            'ROLE_USER',
            'ROLE_ADMIN',
        ]);
        $user->setPassword($password);
        $user->setApiToken(Uuid::v1()->toRfc4122());

        $manager->persist($user);

        $user = new User();
        $password = $this->hasher->hashPassword($user, '00000000');
        $user->setLogin('diana');
        $user->setEmail('diana@mail.ru');
        $user->setRoles([
            'ROLE_USER',
        ]);
        $user->setPassword($password);
        $user->setApiToken(Uuid::v1()->toRfc4122());

        $manager->persist($user);


        for ($i = 0; $i < 20; $i++) {
            
            if($i % 4 == 0){
                $news = new News;
                $news->setName('Спорт');
                $news->setDescription('Взявшая золото российская фигуристка Валиева восхитила японцев');
                $news->setContent('Японский журналист Хитоси Курасава оценил в своей статье для издания Mainichi Shimbun выступление российской фигуристки Камилы Валиевой, завоевавшей золотую медаль в женском одиночном катании на своем дебютном чемпионате Европы.
Как отмечает автор, Валиева уверенно выиграла свой первый чемпионат такого уровня. При этом второе и третье место также заняли россиянки Анна Щербакова и Александра Трусова. "Таким образом, три российские фигуристки вновь оккупировали весь подиум ЧЕ в Таллине", — написал он.
По словам автора статьи, в финальных прокатах Валиева, которая бурно прогрессировала в каждом своем предыдущем выступлении, показала очень редкие для нее сбои. "Тем не менее характерное для Валиевой соединение холодного расчета с мощью исполнения присутствовало и на этот раз. За технику в произвольной программе она получила 94,58 балла, а оценка за художественное впечатление составила 75,03 балла. Оба результата являются высшими", — указал Курасава.
Журналист напомнил, что в сезоне 2021-2022 года фигуристка одержала пять побед подряд как на национальном, так и на международном уровне. "Особенно на международных соревнованиях: каждый раз, когда она выступает, то обновляет высшее мировое достижение", — подчеркнул он.
При этом Валиева, которую, по словам журналиста, называют самым многообещающим кандидатом на золотую медаль Олимпийских игр в Пекине, уже думает об олимпийской арене. "Пятнадцатилетняя девушка, получившая прозвище "источник огорчений", потому что она "сбивает" боевой дух своих соперниц подавляющей силой своего мастерства, сказала: "Я хочу увидеть Великую Китайскую стену", — заключил Курасава.
Читатели в комментариях к статье также оценили талант российской фигуристки.
"Потрясающий результат Валиевой на чемпионате Европы", — написал пользователь hir.
"Какая у этой девушки сила воли! Хладнокровие, которое наводит на мысль о том, что она по менталитету старше своих 15 лет. Это так подходит для королевы фигурного катания", — указал mar.
"Выражения у всех фигуристок нежные, и выглядят все вроде одинаково, но четверные прыжки у русских потрясающие! Ни одна страна больше не может сравниться с ними по этому показателю. Поэтому Олимпиада уже становится неинтересной", — добавил may.
По результатам чемпионата Европы по фигурному катанию россияне завоевали девять наград из 12 возможных. В женском одиночном катании победила Валиева, второй стала Щербакова, третьей — Трусова. У мужчин сильнейшим был Марк Кондратюк. На пьедестале после соревнований спортивных пар оказались россияне Анастасия Мишина и Александр Галлямов, Евгения Тарасова и Владимир Морозов, Александра Бойкова и Дмитрий Козловский. У танцоров победили Виктория Синицина и Никита Кацалапов, вторыми стали Александра Степанова и Иван Букин.
Олимпийские игры в Пекине пройдут 4-20 февраля.');
                $date = new \DateTime('@'.strtotime('now + 3 hours'));
                $news->setDate($date);
                $news->setViews(0);
                $news->setActive(true);
                $news->setfotopath('1.jpg');
                $news->setUser($user);
                $manager->persist($news);

                $comment = new Comments();
                $comment->setContent("Молодец!");
                $comment->setDateLoad($date);
                $comment->setUser($user);
                $comment->setNewsItem($news);

                $comment->setActive(true);

                $manager->persist($comment);
            }

            else if($i % 4 == 1){
                $news = new News;
                $news->setName('Недвижимость');
                $news->setDescription('Сингапур и Нью-Йорк возглавили рейтинг самых дорогих для жизни городов мира');
                $news->setContent('Сингапур и Нью-Йорк возглавили рейтинг городов с самой высокой стоимостью проживания в мире, следует из рейтинга Worldwide Cost of Living от Economist Intelligence Unit, аналитического подразделения британской компании Economist Group.
Сингапур возглавлял рейтинг с 2014 по 2019 год, затем уступив это звание Парижу и Тель-Авиву.
За Сингапуром и Нью-Йорком в нынешнем рейтинге следуют Тель-Авив, Лос-Анджелес и Гонконг.
По данным аналитиков, шесть из десяти городов, где значительно поднялась стоимость проживания, находятся в США.
Москва и Санкт-Петербург, отмечают создатели рейтинга, также стремительно поднялись в нем — Москва оказалась на 37-м месте, хотя в 2021 году была на 125-й позиции, а Санкт-Петербург теперь на 73-м месте рейтинга по сравнению со 143-м в прошлом году.
Составители рейтинга не включили в него Киев, так как не смогли посетить город, а также Каракас в Венесуэле, "чтобы избежать искажения рейтинга".
Самым "бюджетным" городом для проживания вновь стал Дамаск, также рейтинг замыкают Триполи в Ливии, Тегеран, Тунис и Ташкент.
«
"Цены в мегаполисах во всем мире в среднем увеличились на 8,1% в местной валюте за год… Наше исследование выявило, что стоимость жизни растет самыми быстрыми темпами за как минимум 20 лет", - отмечает газета.

По ее данным, на росте цен сказались ограничения КНР на поставки из-за коронавируса, рост стоимости энергоресурсов и продовольствия, украинский кризис и другие факторы.');
                $date = new \DateTime('@'.strtotime('now + 3 hours'));
                $news->setDate($date);
                $news->setViews(0);
                $news->setfotopath('2.jpg');
                $news->setUser($user);

                $comment = new Comments();
                $comment->setContent("Дороговато конечно");
                $comment->setDateLoad($date);
                $comment->setUser($user);
                $comment->setNewsItem($news);

                $comment->setActive(true);

                $manager->persist($comment);
                $manager->persist($news);
            }

            else if($i % 4 == 2){
                $news = new News;
                $news->setName('Навигатор абитуриента');
                $news->setDescription('Учебный год для иностранных студентов в России может начаться в октябре');
                $news->setContent('Возобновление занятий в российских вузах для иностранных студентов, в том числе и китайских, зависит и от эпидемиологической обстановки в мире, и от процесса восстановления международного авиасообщения, возможно, начало аудиторных занятий будет отложено до октября, заявил журналистам во вторник представитель Министерства науки и высшего образования России в Китае, первый секретарь посольства РФ в КНР Игорь Поздняков.
"Говорить о том, что возобновление ожидается – можно, возобновятся ли занятия – это будет зависеть от текущей эпидемиологической ситуации в России и в Китае", – заявил Поздняков.
При этом он отметил, что "в то же время мы готовы к такому развитию событий, что, возможно, придется отложить начало аудиторных занятий до 1 октября, поэтому мы в предварительном порядке информируем наших партнеров, в том числе министерство образования КНР о том, что, например, для стипендиатов, которые отправляются в Россию по государственной линии, не исключаем возможности проведения в сентябре для них занятий онлайн, дистанционно".
"Из чего можно сделать вывод, что (начать – ред.) аудиторные занятия мы предполагаем в октябре, но опять-таки возможны другие варианты, это зависит не только от текущей эпидемиологической ситуации в России или в Китае, или в мире в целом, но в том числе и от целого ряда организационных вопросов, включая возобновление международного авиасообщения, что связано в том числе с работой авиакомпаний, визовыми вопросами", – указал дипломат.');
                $date = new \DateTime('@'.strtotime('now + 3 hours'));
                $news->setDate($date);
                $news->setViews(0);
                $news->setActive(true);
                $news->setfotopath('3.jpg');
                $news->setUser($user);
                $manager->persist($news);

                $comment = new Comments();
                $comment->setContent("Очень познавательно!");
                $comment->setDateLoad($date);
                $comment->setUser($user);
                $comment->setNewsItem($news);


                $manager->persist($comment);
            }

            else{
                $news = new News;
                $news->setName('COVID-19 и Вузы');
                $news->setDescription('COVID-19 отступает? Как вузы разных стран готовятся к осеннему семестру');
                $news->setContent('Российским вузам надо готовиться к тому, что осенний семестр, возможно, придется провести в дистанционном формате, считает вице-премьер РФ Татьяна Голикова. В аналогичной ситуации сейчас находятся университеты подавляющего большинства стран. О том, какие меры принимают вузы всего мира, адаптируясь к пост-вирусной реальности, читайте в новом материале РИА Новости.
В связи с пандемией COVID-19 с марта по июнь 2020 года учебная и исследовательская активность практически во всех вузах мира ограничивалась возможностями удаленного доступа. Были закрыты почти все лаборатории, библиотеки и другие публичные пространства.
Как минимум до августа останутся под запретом все массовые мероприятия, и даже церемонии вручения дипломов во многих университетах будут отложены или пройдут онлайн. С конца мая многие вузы приступили к масштабной подготовке персонала и кампусов для следующего учебного года, который принесет много новшеств.
Строгие рамки
Несмотря на то, что эпидемиологическая ситуация в некоторых странах налаживается, соблюдение норм гигиены и социальной дистанции остается максимально строгим требованием во всем мире.
Успех в борьбе с вирусом, как считает, например, руководство Токийского университета, возможен только в том случае, если устранить из жизни вуза три фактора: работу в закрытых помещениях, скопления людей и близкий физический контакт между ними.
Согласно регламенту большинства вузов, безопасным считается контакт с расстояния около двух метров. По правилам Швейцарской высшей технической школы для восстановления работы лабораторий потребуется реорганизовать пространство так, чтобы на одного человека приходилось минимум 10 м2. Антисептические препараты, перчатки и маски останутся ежедневной необходимостью.
Укреплению новых гигиенических норм уделяется большое внимание. Многие университеты, как, например, Стенфордский, запустили онлайн-тренинги по подготовке персонала к работе в новых санитарных условиях. Только пройдя этот курс, можно будет вернуться в кампус.
Наряду с тестами на коронавирус и бесконтактными термометрами другим важным средством борьбы с распространением инфекции, внедряемым в университетский быт, являются системы мониторинга наподобие сингапурского SafeEntry или оксфордского Health Check. Они позволяют отслеживать состояние персонала и регулировать доступ в кампус в зависимости от показателей.
Кроме того, многие вузы, такие как сингапурский NUS, ввели на своей территории систему зонирования, предполагающую дополнительный пропускной режим внутри кампуса. Также персонал NUS использует приложение TraceTogether, контролирующее контакты между людьми. Подобные приложение активно тестируются и в других университетах, например, в Швейцарской высшей технической школе.');
                $date = new \DateTime('@'.strtotime('now + 3 hours'));
                $news->setDate($date);
                $news->setViews(0);
                $news->setfotopath('4.jpg');
                $news->setUser($user);
                $manager->persist($news);

                $comment = new Comments();
                $comment->setContent("Ох уж этот ковид");
                $comment->setDateLoad($date);
                $comment->setUser($user);
                $comment->setNewsItem($news);


                $manager->persist($comment);

            }
        }
        $manager->flush();
    }
}
