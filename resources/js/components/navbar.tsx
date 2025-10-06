import { navItems } from '@/data';
import { Link } from '@inertiajs/react';
import { BriefcaseBusiness, Menu, Search, X } from 'lucide-react';
import { memo, MouseEvent, useEffect, useRef, useState } from 'react';
import GameSearchSelect from './search';
import ThemeSelector from './theme-toggle';
import Image from './ui/loading-image';
import Logo from './ui/logo';

const Navbar = memo(() => {
    const [showMenu, setShowMenu] = useState(false);
    const [showSearch, setShowSearch] = useState(false);
    const search = useRef<HTMLDivElement>(null);
    const cardSearch = useRef<HTMLDivElement>(null);
    const menuRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        const handleClickOutside = (event: globalThis.MouseEvent) => {
            if (
                menuRef.current &&
                !menuRef.current.contains(event.target as Node) &&
                search.current &&
                !search.current.contains(event.target as Node) &&
                cardSearch.current &&
                !cardSearch.current.contains(event.target as Node)
            ) {
                setShowMenu(false);
                setShowSearch(false);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    // handle close by scroll
    useEffect(() => {
        const handleScroll = () => {
            setShowMenu(false);
            setShowSearch(false);
        };

        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    // handle search show
    const handleShowSearch = (e: MouseEvent<HTMLButtonElement>) => {
        setShowSearch((prev) => !prev);
        e.preventDefault();
    };

    return (
        <header className="bg-secondary text-white shadow-sm">
            <div className="flex w-full flex-col items-center">
                <div className="top container mx-auto flex w-full items-center justify-between px-4 py-2 md:gap-8">
                    {/* Logo */}
                    <Logo />
                    {/* Search */}

                    <GameSearchSelect search={search} showSearch={showSearch} cardSearch={cardSearch} setShowSearch={setShowSearch} />
                    <div className="me-2 flex min-w-fit items-center justify-center gap-2 md:me-0">
                        <button onClick={(e) => handleShowSearch(e)} className="size-5 md:hidden">
                            <Search className="h-full w-full" />
                        </button>
                        {/* Currency */}
                        <div className="flex items-center gap-2">
                            <span className="text-sm">ID / IDR</span>
                            <Image src="/storage/website/indonesia.png" alt="ID flag" className="h-5 w-5" />
                        </div>

                        <ThemeSelector mobile={false} />
                    </div>
                    {/* Mobile menu button */}
                    <button onClick={() => setShowMenu(true)} className="block text-white sm:hidden lg:hidden">
                        <Menu className="size-6" />
                    </button>
                </div>

                <hr className="bg-primary h-[0.2px] w-full" />

                <div className="bottom container mx-auto hidden w-full px-4 py-2.5 sm:inline-block">
                    {/* Navigation */}
                    <nav className="flex w-full items-center justify-between gap-6">
                        <ul className="flex items-center gap-6">
                            <li>
                                <a href="#product" className="text-sm font-medium transition hover:text-white/90">
                                    <p className="flex items-center gap-2">
                                        <span>
                                            <BriefcaseBusiness className="size-5" />
                                        </span>
                                        Topup
                                    </p>
                                </a>
                            </li>
                            {navItems.map((item) => (
                                <li key={item.name}>
                                    <Link href={route(item.route)} className="text-sm font-medium transition hover:text-white/90">
                                        <p className="flex items-center gap-2">
                                            <span>
                                                <item.icon className="size-5" />
                                            </span>

                                            {item.name}
                                        </p>
                                    </Link>
                                </li>
                            ))}

                            {/* Hidden dashboard link for future */}
                            <li className="hidden">
                                {/* <Link href={route('auth.dashboard')}>Dashboard</Link> */}
                                <p>Dashboard</p>
                            </li>
                        </ul>

                        {/* Auth */}
                        <div className="flex items-center gap-4">
                            {/* <Link href={route('auth.login')}>
                                <p className="cursor-not-allowed text-sm font-medium text-gray-400 hover:text-white/90">Masuk</p>
                            </Link>
                            <Link href={route('auth.register')}>
                                <p className="cursor-not-allowed text-sm font-medium text-gray-400 hover:text-white/90">Daftar</p>
                            </Link> */}
                        </div>
                    </nav>
                </div>
            </div>
            {/* Offcanvas menu */}
            <div
                ref={menuRef}
                className={`bg-secondary fixed inset-y-0 left-0 z-9 w-64 p-4 text-white transition-transform duration-300 ${
                    showMenu ? 'translate-x-0' : '-translate-x-full'
                } lg:hidden`}
            >
                <div className="flex items-center justify-between pb-4">
                    <Logo />
                    <button onClick={() => setShowMenu(false)}>
                        <X className="size-6" />
                    </button>
                </div>

                <nav className="min-h-screen space-y-4">
                    <Link href="#product" className="flex items-center gap-2 text-sm">
                        <BriefcaseBusiness className="size-5" />
                        Topup
                    </Link>
                    <ul className="h-full w-full space-y-4">
                        {navItems.map((item) => (
                            <Link key={item.name} href={route(item.route)} className="flex items-center gap-2 text-sm">
                                <item.icon className="size-5" />
                                {item.name}
                            </Link>
                        ))}
                    </ul>

                    <div className="space-y-2 border-t border-gray-600 pt-4">
                        {/* <Link href={route('auth.login')}>
                            <p className="cursor-not-allowed text-sm text-gray-400">Masuk</p>
                        </Link>
                        <Link href={route('auth.register')}>
                            <p className="cursor-not-allowed text-sm text-gray-400">Daftar</p>
                        </Link> */}
                    </div>

                    <div className="off-canvas flex h-full min-h-[42vh] items-end justify-end">
                        <ThemeSelector mobile={true} />
                    </div>
                </nav>
            </div>
        </header>
    );
});

export default Navbar;
