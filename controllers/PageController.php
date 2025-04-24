<?php

class PageController
{
    private $user;
    // private $hrDepartmentId = 64;
    private $hrDepartmentId = 444;
    private $userMapping = [
        3 => "Oday Shoubaki",
        148 => "Tosif Ahmed",
        150 => "Nichol Mistoso",
        204 => "IT Administrator",
        228 => "Taimour Mufti",
        553 => "Marita Nicholas",
        1281 => "Baha'a Nofal abdel hameed",
        1376 => "Mohammed Razy Mr. Kopa",
        1404 => "Elsayed Elgalad",
        1510 => "Marian Ibay",
        1518 => "Mohamed Hamada",
        1534 => "Mahmoud Kizawi",
        1587 => "Ahmed Hamada Yousef",
        1589 => "Islam Shobaky",
        1593 => "Alyssa Ashley Erise",
        1594 => "Carlo Guian",
        1635 => "Stephane Nito Sob",
        1636 => "Yanoulla Evangelou",
        1650 => "Mohammad Al Shoubaki",
        1653 => "Odai Shoubaki",
        1661 => "Ahmed Elsherif",
        1671 => "Jerome delos Santos jayke",
        1675 => "Nour Eldin",
        1711 => "Thierno Ndao",
        1712 => "Nuha Sayjari",
        1721 => "Mohamed Hossam",
        1722 => "Saleh Dawabsheh",
        1731 => "Jungeun Nam",
        1788 => "Maha Elbahnasi",
        1789 => "Fouad Houda",
        1792 => "Aluat Akol Them",
        1804 => "Randa Dinnawi",
        1820 => "Marmora Moaty",
        1823 => "Deborah Stubbs",
        1825 => "Ashley Simoes",
        1828 => "Emmanuel Stephen",
        1838 => "Afrah Abdalaziz",
        1846 => "Shahad Shamel ALTaee",
        1852 => "Shireen Zagha zagha",
        1856 => "Ahmad Zamel",
        1861 => "Noran Anwar",
        1863 => "Emad Younes",
        1875 => "Ahmed Amin",
        1876 => "Rahma Negm",
        1877 => "Abdallah Damer",
        1879 => "Konstantin",
        1880 => "Radwa Mounir",
        1881 => "Hamza Alhamawi",
        1884 => "Laila Kastali",
        1888 => "Faisal Brahimi",
        1891 => "Manoj Hingorani",
        1893 => "Justine Panganiban Jat",
        1894 => "Furkat Ibragimiv",
        1902 => "Nadia Kirouane",
        1903 => "Mohamed Saed",
        1905 => "Reem Alsuwaidi",
        1912 => "Mariyam Kaltai",
        1922 => "Mohamed Nagy",
        1927 => "Shammel .",
        1928 => "Nancy Ahmed",
        1929 => "Ahmed Bahgat",
        1934 => "Thulfiqar Alsheikhly",
        1937 => "Nada Moheb",
        1938 => "Ruba Ghraizi",
        1945 => "Aaryan Daboria",
        1948 => "Souzan Taha",
        1949 => "Rana Hosny",
        1950 => "Sherif El-Ziny",
        1956 => "Hager Hamdy",
        1959 => "Adel Al-Hamam",
        1961 => "Houda Lasfar",
        1963 => "Yuqing Iris Guo",
        1964 => "Ahmed Samir",
        1965 => "Amer Habib",
        2034 => "Neha Gaur",
        2035 => "Anna Serikova",
        2055 => "Ahmad Amro",
        2058 => "Marvin Jedd Domingo Ortiz",
        2060 => "Webbee Support",
        2061 => "Ahmad Mujahed",
        2064 => "Leon Schonwalder",
        2065 => "Eszter Al-Kaissy",
        2082 => "Gi Academy",
        2127 => "Faisal Abbas",
        2152 => "Ziyu Jiang",
        2154 => "Saizhu Cao",
        2185 => "Majid Mohamed Elshorafa",
        2186 => "Ayham Sabeel",
        2199 => "Yomna Abdallah",
        2210 => "Afraz Azhar",
        2212 => "Michael Manfred",
        2214 => "Manoj Kumar Mohapatra",
        2243 => "Wajiha Khan",
        2295 => "Nour El-Houda Zaghlaoui",
        2296 => "Fatih Mitu",
        2298 => "Noor Al Qal'i",
        2469 => "Muhammad Riaz",
        2470 => "Puneet Parashar"
    ];

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function render($page)
    {
        $userId = $this->user['ID'];
        $isHR = in_array($this->hrDepartmentId, (array) $this->user['UF_DEPARTMENT']);

        if ($isHR) {
            $allowed = ['dashboard', 'inbox', 'archive', 'templates', 'config', 'track', 'send', 'log', 'notifications', 'addtemplate'];
        } else {
            $allowed = ['myforms', 'fill', 'submitted', 'history', 'alerts'];
        }

        if (!in_array($page, $allowed)) {
            $page = $isHR ? 'dashboard' : 'myforms';
        }

        // Load controller
        $controllerFile = __DIR__ . '/' . ucfirst($page) . 'Controller.php';
        $controllerClass = ucfirst($page) . 'Controller';
        $data = [];

        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass($this->user, $this->userMapping);

                if (method_exists($controller, 'index')) {
                    $data = $controller->index();
                }
            }
        }

        $data['isHR'] = $isHR;
        $data['userId'] = $userId;
        $data['user'] = $this->user;

        extract($data);

        include __DIR__ . '/../views/layout/head.php';

        echo '<div class="flex h-screen">';
        include __DIR__ . '/../views/layout/sidebar.php';

        echo '<main class="flex-1 overflow-y-auto p-6">';
        include __DIR__ . '/../views/' . $page . '.php';
        echo '</main></div>';

        include __DIR__ . '/../views/layout/footer.php';
    }
}
