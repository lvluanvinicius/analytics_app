import { UsersFilter } from "@/components/users/users-filter";
import { UsersPaginate } from "@/components/users/users-paginate";
import { UsersTable } from "@/components/users/users-table";
import { getUsers } from "@/services/queries/get-users";
import { useQuery } from "@tanstack/react-query";
import { Helmet } from "react-helmet-async";

export function Users() {
    const search = null;

    const { data: users } = useQuery({
        queryKey: ["users"],
        queryFn: () => getUsers({ search }),
    });

    if (!users) {
        return null;
    }
    
    return (
        <div className="">
            <Helmet title="Usuários" />
            <UsersFilter />
            <UsersTable users={users.data} />
            <UsersPaginate />
        </div>
    );

}
