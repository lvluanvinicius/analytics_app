import { Outlet } from 'react-router-dom'

export function AppLayout() {
    return <div className='bg-black h-[100vh]'>
        //

        <Outlet />
    </div>
}