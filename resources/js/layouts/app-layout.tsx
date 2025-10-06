import Carousell from '@/components/carousell';
import Footer from '@/components/footer';
import Navbar from '@/components/navbar';
import { useCategory } from '@/hooks/useCategory';
import { categoriesType } from '@/types';
import { Head, usePage } from '@inertiajs/react';

type props = { categories: categoriesType[] };

export default function AppLayout({ children }: { children: React.ReactNode }) {
    const { categories } = usePage<props>().props;
    const { category } = useCategory();

    return (
        <div className="bg-popover flex min-h-screen min-w-screen flex-col overflow-hidden">
            <Head>
                <title>{categories[category - 1].title}</title>
                <meta name="description" content={categories[category - 1].description} />
            </Head>

            <Navbar />

            <main className="overflow-hidden">
                {categories ? <Carousell /> : null}
                <section style={{ backfaceVisibility: 'hidden' }} className="container mx-auto flex-1 py-6">
                    {children}
                </section>
            </main>

            <Footer />
        </div>
    );
}
