import { ArrowLeft, ArrowRight } from 'lucide-react';

const HomePage = () => {
    return (
        <div className="w-full">
            {/* Banner / Hero Section */}
            <section className="relative w-full overflow-hidden">
                <div className="flex w-full">
                    <div className="w-full flex-none">
                        <img src="/path/to/banner.jpg" alt="Banner" className="h-full w-full object-contain object-bottom" />
                    </div>
                </div>
                {/* Carousel navigation */}
                <button className="absolute top-1/2 left-2 z-10 -translate-y-1/2 rounded-full bg-black/50 p-2">
                    <ArrowLeft className="h-7 w-7 text-white" />
                </button>
                <button className="absolute top-1/2 right-2 z-10 -translate-y-1/2 rounded-full bg-black/50 p-2">
                    <ArrowRight className="h-7 w-7 text-white" />
                </button>
            </section>

            {/* Section Populer */}
            <section className="bg-primary mx-auto my-10 max-w-7xl rounded-lg px-6 py-10 text-white">
                <div className="mb-6">
                    <h2 className="text-2xl font-semibold">Top Up Populer</h2>
                    <p className="text-sm text-gray-300">Pilihan terbaik dari user lain</p>
                </div>
                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    {/* Example Card */}
                    <div className="to-primary flex items-center gap-4 rounded-xl bg-gradient-to-br from-gray-800 p-4">
                        <img src="/path/to/icon.png" alt="Icon" className="h-12 w-12" />
                        <div>
                            <h4 className="font-medium text-white">Nama Produk</h4>
                            <p className="text-sm text-gray-300">Deskripsi</p>
                        </div>
                    </div>
                    {/* Repeat as needed */}
                </div>
            </section>
        </div>
    );
};

export default HomePage;
