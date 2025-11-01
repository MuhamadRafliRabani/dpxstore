import Carousell from '@/components/carousell';
import Footer from '@/components/footer';
import Navbar from '@/components/navbar';
import { useCategory } from '@/hooks/useCategory';
import { categoriesType } from '@/types';
import { Head, usePage } from '@inertiajs/react';

type props = { categories: categoriesType[] };

export default function AppLayout({ children }: { children: React.ReactNode }) {
    const { categories, show = false } = usePage<props>().props;
    const { category } = useCategory();

    return (
        <div className="bg-popover flex max-w-screen flex-col justify-center overflow-hidden">
            <Head>
                <title>{categories[category - 1].title ?? ''}</title>
                <meta name="description" content={categories[category - 1].description ?? ''} />
            </Head>

            <Navbar />

            <main className="container mx-auto max-w-lg flex-1 overflow-hidden pt-2 pb-4 sm:max-w-xl md:max-w-3xl lg:max-w-5xl xl:max-w-6xl">
                {show ? <Carousell /> : null}
                <section style={{ backfaceVisibility: 'hidden' }}>{children}</section>
            </main>

            <Footer />
        </div>
    );
}
