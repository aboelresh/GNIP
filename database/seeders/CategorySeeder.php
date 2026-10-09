<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'slug' => 'politics',
                'icon' => '🏛️',
                'color' => '#3B82F6',
                'order' => 1,
                'name' => [
                    'en' => 'Politics',
                    'ar' => 'سياسة',
                    'fr' => 'Politique',
                    'it' => 'Politica',
                    'es' => 'Política',
                ],
                'description' => [
                    'en' => 'Political news and government affairs',
                    'ar' => 'أخبار سياسية وشؤون حكومية',
                    'fr' => 'Actualités politiques et affaires gouvernementales',
                    'it' => 'Notizie politiche e affari governativi',
                    'es' => 'Noticias políticas y asuntos gubernamentales',
                ],
            ],
            [
                'slug' => 'conflicts',
                'icon' => '⚔️',
                'color' => '#EF4444',
                'order' => 2,
                'name' => [
                    'en' => 'Military & Conflicts',
                    'ar' => 'عسكري وصراعات',
                    'fr' => 'Militaire et conflits',
                    'it' => 'Militare e conflitti',
                    'es' => 'Militar y conflictos',
                ],
                'description' => [
                    'en' => 'Military operations and armed conflicts',
                    'ar' => 'العمليات العسكرية والنزاعات المسلحة',
                    'fr' => 'Opérations militaires et conflits armés',
                    'it' => 'Operazioni militari e conflitti armati',
                    'es' => 'Operaciones militares y conflictos armados',
                ],
            ],
            [
                'slug' => 'economy',
                'icon' => '📈',
                'color' => '#10B981',
                'order' => 3,
                'name' => [
                    'en' => 'Economy',
                    'ar' => 'اقتصاد',
                    'fr' => 'Économie',
                    'it' => 'Economia',
                    'es' => 'Economía',
                ],
                'description' => [
                    'en' => 'Economic news and financial markets',
                    'ar' => 'أخبار اقتصادية وأسواق مالية',
                    'fr' => 'Actualités économiques et marchés financiers',
                    'it' => 'Notizie economiche e mercati finanziari',
                    'es' => 'Noticias económicas y mercados financieros',
                ],
            ],
            [
                'slug' => 'technology',
                'icon' => '💻',
                'color' => '#8B5CF6',
                'order' => 4,
                'name' => [
                    'en' => 'Technology',
                    'ar' => 'تكنولوجيا',
                    'fr' => 'Technologie',
                    'it' => 'Tecnologia',
                    'es' => 'Tecnología',
                ],
                'description' => [
                    'en' => 'Technology and innovation news',
                    'ar' => 'أخبار التكنولوجيا والابتكار',
                    'fr' => 'Actualités technologiques et innovation',
                    'it' => 'Notizie tecnologiche e innovazione',
                    'es' => 'Noticias tecnológicas e innovación',
                ],
            ],
            [
                'slug' => 'science',
                'icon' => '🔬',
                'color' => '#06B6D4',
                'order' => 5,
                'name' => [
                    'en' => 'Science',
                    'ar' => 'علوم',
                    'fr' => 'Science',
                    'it' => 'Scienza',
                    'es' => 'Ciencia',
                ],
                'description' => [
                    'en' => 'Scientific discoveries and research',
                    'ar' => 'الاكتشافات العلمية والأبحاث',
                    'fr' => 'Découvertes scientifiques et recherche',
                    'it' => 'Scoperte scientifiche e ricerca',
                    'es' => 'Descubrimientos científicos e investigación',
                ],
            ],
            [
                'slug' => 'health',
                'icon' => '🏥',
                'color' => '#F59E0B',
                'order' => 6,
                'name' => [
                    'en' => 'Health',
                    'ar' => 'صحة',
                    'fr' => 'Santé',
                    'it' => 'Salute',
                    'es' => 'Salud',
                ],
                'description' => [
                    'en' => 'Health and medical news',
                    'ar' => 'أخبار الصحة والطب',
                    'fr' => 'Actualités santé et médicales',
                    'it' => 'Notizie sanitarie e mediche',
                    'es' => 'Noticias de salud y medicina',
                ],
            ],
            [
                'slug' => 'environment',
                'icon' => '🌍',
                'color' => '#84CC16',
                'order' => 7,
                'name' => [
                    'en' => 'Environment',
                    'ar' => 'بيئة',
                    'fr' => 'Environnement',
                    'it' => 'Ambiente',
                    'es' => 'Medio ambiente',
                ],
                'description' => [
                    'en' => 'Environmental and climate news',
                    'ar' => 'أخبار البيئة والمناخ',
                    'fr' => 'Actualités environnementales et climatiques',
                    'it' => 'Notizie ambientali e climatiche',
                    'es' => 'Noticias ambientales y climáticas',
                ],
            ],
            [
                'slug' => 'sports',
                'icon' => '⚽',
                'color' => '#F97316',
                'order' => 8,
                'name' => [
                    'en' => 'Sports',
                    'ar' => 'رياضة',
                    'fr' => 'Sports',
                    'it' => 'Sport',
                    'es' => 'Deportes',
                ],
                'description' => [
                    'en' => 'Sports news and results',
                    'ar' => 'أخبار ونتائج الرياضة',
                    'fr' => 'Actualités sportives et résultats',
                    'it' => 'Notizie sportive e risultati',
                    'es' => 'Noticias deportivas y resultados',
                ],
            ],
            [
                'slug' => 'business',
                'icon' => '💼',
                'color' => '#6B7280',
                'order' => 9,
                'name' => [
                    'en' => 'Business',
                    'ar' => 'أعمال',
                    'fr' => 'Affaires',
                    'it' => 'Affari',
                    'es' => 'Negocios',
                ],
                'description' => [
                    'en' => 'Business and corporate news',
                    'ar' => 'أخبار الأعمال والشركات',
                    'fr' => 'Actualités commerciales et d\'entreprise',
                    'it' => 'Notizie commerciali e aziendali',
                    'es' => 'Noticias comerciales y empresariales',
                ],
            ],
            [
                'slug' => 'international',
                'icon' => '🌐',
                'color' => '#EC4899',
                'order' => 10,
                'name' => [
                    'en' => 'International Affairs',
                    'ar' => 'شؤون دولية',
                    'fr' => 'Affaires internationales',
                    'it' => 'Affari internazionali',
                    'es' => 'Asuntos internacionales',
                ],
                'description' => [
                    'en' => 'International relations and diplomacy',
                    'ar' => 'العلاقات الدولية والدبلوماسية',
                    'fr' => 'Relations internationales et diplomatie',
                    'it' => 'Relazioni internazionali e diplomazia',
                    'es' => 'Relaciones internacionales y diplomacia',
                ],
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('✅ Categories seeded: '.count($categories));
    }
}
